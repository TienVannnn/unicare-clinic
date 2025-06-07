<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Jobs\MailAccountJob;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-nguoi-dung');
        $title = 'Danh sách người dùng';
        $users = User::orderByDesc('id')->paginate(15);
        return view('admin.user.list', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-nguoi-dung');
        $title = 'Thêm mới người dùng';
        return view('admin.user.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->authorize('them-nguoi-dung');
        try {
            DB::beginTransaction();
            $rand = rand(100000, 999999);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($rand),
                'verify_email' => $request->verify_email
            ]);
            DB::commit();
            Session::flash('success', 'Tạo người dùng thành công');
            MailAccountJob::dispatch($user, $rand)->delay(now()->addSecond(10));
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Có lỗi khi tạo: ' . $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('sua-nguoi-dung');
        $user = User::findOrFail($id);
        $title = 'Chỉnh sửa người dùng';
        return view('admin.user.edit', compact('title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('sua-nguoi-dung');
        $user = User::findOrFail($id);
        try {
            DB::beginTransaction();
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'verify_email' => $request->verify_email
            ]);
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/avatars'), $filename);

                if ($user->avatar && file_exists(public_path($user->avatar))) {
                    unlink(public_path($user->avatar));
                }
                $user->avatar = '/uploads/avatars/' . $filename;
            }
            $user->save();
            DB::commit();
            Session::flash('success', 'Cập nhật người dùng thành công');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Có lỗi khi chỉnh sửa: ' . $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-nguoi-dung');
        $user = User::findOrFail($id);
        try {
            if ($user->avatar) {
                $avatarPath = public_path($user->avatar);
                if (file_exists($avatarPath)) {
                    unlink($avatarPath);
                }
            }
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Xóa người dùng thành công.']);
        } catch (\Exception $e) {
            return  response()->json(['success' => false, 'message' => 'Có lỗi khi xóa']);
        }
    }
}
