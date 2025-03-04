<?php

namespace App\Http\Controllers\User;

use App\Events\ContactEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ContactRequest;
use App\Models\Contact;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function home()
    {
        $title = 'Trang chủ';
        $news = News::orderByDesc('id')->get();
        return view('user.home.home', compact('title', 'news'));
    }

    public function contact_form()
    {
        $title = 'Liên hệ với chúng tôi';
        return view('user.home.contact', compact('title'));
    }

    public function contact(ContactRequest $request)
    {
        try {
            $data = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'title' => $request->title,
                'message' => $request->message,
                'status' => 0
            ]);
            $count = Contact::where('status', 0)->count();
            event(new ContactEvent($data['title'], $data['name'], $count));
            Session::flash('success', 'Gửi liên hệ thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi liên hệ' . $e->getMessage());
        }
        return redirect()->back();
    }
}
