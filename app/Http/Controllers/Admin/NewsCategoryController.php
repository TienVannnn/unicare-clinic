<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsCategoryRequest;
use App\Models\NewsCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NewsCategoryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-muc-tin-tuc');
        $title = 'Danh sách danh mục tin tức';
        $categories = NewsCategory::orderByDesc('id')->paginate(15);
        return view('admin.news-category.list', compact('title', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-danh-muc-tin-tuc');
        $title = 'Thêm mới danh mục tin tức';
        return view('admin.news-category.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsCategoryRequest $request)
    {
        $this->authorize('them-danh-muc-tin-tuc');
        try {
            NewsCategory::create([
                'name' => $request->name,
                'slug' => Helper::createSlug($request->name),
                'status' => $request->status
            ]);
            Session::flash('success', 'Tạo danh mục tin tức thành công');
            return redirect()->route('news-category.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi tạo');
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('chinh-sua-danh-muc-tin-tuc');
        $category = NewsCategory::findOrFail($id);
        $title = 'Chỉnh sửa danh mục tin tức';
        return view('admin.news-category.edit', compact('title', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsCategoryRequest $request, string $id)
    {
        $this->authorize('chinh-sua-danh-muc-tin-tuc');
        $category = NewsCategory::findOrFail($id);
        try {
            $category->update([
                'name' => $request->name,
                'slug' => Helper::createSlug($request->name),
                'status' => $request->status
            ]);
            Session::flash('success', 'Cập nhật danh mục tin tức thành công');
            return redirect()->route('news-category.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi chỉnh sửa');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-danh-muc-tin-tuc');
        $category = NewsCategory::findOrFail($id);
        try {
            $category->delete();
            return response()->json(['success' => true, 'message' => 'Xóa danh mục tin tức thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa danh mục tin tức vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa danh mục tin tức: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}
