<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::orderByDesc('id')->with('user', 'department')->paginate(12);
        $title = 'Danh sách câu hỏi';
        return view('admin.faq.list', compact('title', 'faqs'));
    }

    public function show(string $id)
    {
        $this->authorize('xem-chi-tiet-lien-he');
        $faq = Faq::with('user', 'department')->findOrFail($id);
        $doctor  = auth()->guard('admin')->user();
        if ($faq->is_viewed == 0) $faq->update(['is_viewed' => 1]);
        $title = 'Chi tiết câu hỏi';
        return view('admin.faq.detail_faq', compact('title', 'faq', 'doctor'));
    }

    public function update(Request $request, string $id)
    {
        $this->authorize('tra-loi-lien-he');
        $request->validate(
            [
                'answer' => 'required|string',
                'status' => 'required|in:0,1'
            ],
            [
                'answer.required' => 'Vui lòng nhập câu trả lời',
                'answer.string' => 'Câu trả lời là chuỗi',
                'status.required' => 'Trạng thái là bắt buộc',
                'status.in' => 'Trạng thái không hợp lệ'
            ]
        );
        try {
            $faq = Faq::findOrFail($id);
            $faq->update([
                'doctor_id' => auth()->guard('admin')->id(),
                'answer' => $request->answer,
                'status' => $request->status
            ]);
            Session::flash('success', 'Trả lời câu hỏi thành công');
            return redirect()->route('faq.index');
        } catch (\Exception) {
            Session::flash('error', 'Có lỗi xảy ra khi trả lời');
            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        $this->authorize('xoa-lien-he');
        $faq = Faq::findOrFail($id);
        try {
            $faq->delete();
            return response()->json(['success' => true, 'message' => 'Xóa câu hỏi thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa câu hỏi vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa câu hỏi: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}
