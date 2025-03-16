<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ContactReplyJob;
use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-lien-he');
        $title = 'Danh sách tin nhắn liên hệ';
        $contacts = Contact::orderByDesc('id')->paginate(15);
        return view('admin.contact.list', compact('title', 'contacts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('xem-chi-tiet-lien-he');
        $contact = Contact::findOrFail($id);
        if ($contact->status == 0) $contact->update(['status' => 1]);
        $replies = $contact->contactReplies;
        $title = 'Chi tiết tin nhắn liên hệ';
        return view('admin.contact.detail_contact', compact('title', 'contact', 'replies'));
    }

    public function destroy(string $id)
    {
        $this->authorize('xoa-lien-he');
        $contact = Contact::findOrFail($id);
        try {
            $contact->delete();
            return response()->json(['success' => true, 'message' => 'Xóa tin nhắn thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa tin nhắn vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa tin nhắn: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }

    public function delete($id)
    {
        $this->authorize('xoa-lien-he');
        $contact = Contact::findOrFail($id);
        try {
            $contact->delete();
            Session::flash('success', 'Xóa tin nhắn thành công');
            return redirect()->route('contact.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi xóa tin nhắn');
            return redirect()->back();
        }
    }

    public function page_reply($id)
    {
        $this->authorize('tra-loi-lien-he');
        $title = 'Phản hồi liên hệ';
        $contact = Contact::findOrFail($id);
        return view('admin.contact.contact-reply', compact('title', 'contact'));
    }

    public function reply(Request $request)
    {
        $this->authorize('tra-loi-lien-he');
        try {
            $contact = Contact::findOrFail($request->id);
            $title = $request->title;
            $content = $request->content;
            ContactReply::create([
                'title' => $title,
                'content' => $content,
                'admin_id' => auth()->guard('admin')->id(),
                'contact_id' => $contact->id
            ]);
            $contact->update(['status' => 2]);
            Session::flash('success', 'Phản hồi thư thành công');
            ContactReplyJob::dispatch($title, $request->email, $content)->delay(now()->addSecond(10));
            return redirect()->route('contact.show', $contact->id);
        } catch (\Exception) {
            Session::flash('error', 'Có lỗi xảy ra khi phản hồi');
            return redirect()->back();
        }
    }

    public function allDelete(Request $request)
    {
        $this->authorize('xoa-lien-he');
        try {
            $count = count($request->ids);
            Contact::whereIn('id', $request->ids)->delete();
            return response()->json(['success' => true, 'message' => "Đã xóa thành công $count tin nhắn!"]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi khi xóa!']);
        }
    }


    public function markRead($id)
    {
        $contact = Contact::findOrFail($id);
        try {
            if ($contact->status == 1) {
                $contact->update(['status' => 0]);
                Session::flash('success', 'Đánh dấu là chưa đọc');
            } elseif ($contact->status == 0) {
                $contact->update(['status' => 1]);
                Session::flash('success', 'Đánh dấu là đã đọc');
            }
        } catch (\Exception) {
            Session::flash('error', 'Có lỗi');
        }
        return redirect()->back();
    }

    public function markReadAll(Request $request)
    {
        try {
            $count = count($request->ids);
            Contact::whereIn('id', $request->ids)->where('status', 0)->update(['status' => 1]);
            return response()->json(['success' => true, 'message' => "$count tin nhăn được đánh dấu là đã đọc!"]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật!']);
        }
    }

    public function markUnreadAll(Request $request)
    {
        try {
            $count = count($request->ids);
            Contact::whereIn('id', $request->ids)->update(['status' => 0]);
            return response()->json(['success' => true, 'message' => "$count tin nhắn được đánh dấu là chưa đọc!"]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật!']);
        }
    }

    public function unreadAppointments()
    {
        $this->authorize('xem-danh-sach-lien-he');
        $title = 'Danh sách tin nhắn chưa đọc';
        $contacts = Contact::where('status', 0)->orderByDesc('id')->paginate(15);
        return view('admin.contact.unreadList', compact('title', 'contacts'));
    }
}
