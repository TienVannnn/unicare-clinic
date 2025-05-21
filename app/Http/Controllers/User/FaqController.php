<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AskQuestionRequest;
use App\Models\Department;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FaqController extends Controller
{
    public function faq()
    {
        $faqs = Faq::where('status', 1)->orderByDesc('id')->paginate(5);
        $departments = Department::orderByDesc('id')->where('status', 1)->get();
        $title = 'Đặt câu hỏi với các bác sĩ của Uni Care';
        return view('user.faq.faq', compact('title', 'faqs', 'departments'));
    }

    public function ask_question(AskQuestionRequest $request)
    {
        DB::beginTransaction();
        try {
            Faq::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'department_id' => $request->department,
                'question' => $request->question
            ]);
            DB::commit();
            Session::flash('success', 'Đặt câu hỏi thành công. Bạn có thể kiểm tra câu hỏi trong hồ sơ');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Có lỗi khi đặt câu hỏi');
        }
        return redirect()->back();
    }

    public function faq_department($slug)
    {
        $departments = Department::where('status', 1)->orderByDesc('id')->get();
        $de = Department::where('slug', $slug)->where('status', 1)->first();
        $faqs = Faq::where('department_id', $de->id)->where('status', 1)->orderByDesc('id')->paginate(5);
        $title = 'Hỏi đáp - ' . $de->name;
        return view('user.faq.faq', compact('title', 'faqs', 'de', 'departments'));
    }
}
