<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-tin-tuc');
        $title = 'Danh sách tin tức';
        $news = News::orderByDesc('id')->with('newsCategories')->paginate(15);
        return view('admin.news.list', compact('title', 'news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-tin-tuc');
        $title = 'Thêm tin tức';
        $categories = NewsCategory::where('status', 1)->orderByDesc('id')->get();
        return view('admin.news.create', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        try {
            DB::beginTransaction();
            $news = News::create([
                'title' => $request->title,
                'slug' => Helper::createSlug($request->title),
                'content' => $request->content,
                'status' => $request->status,
                'poster_id' => auth()->guard('admin')->id(),
                'thumbnail' => '/uploads/news/default.jpg'
            ]);
            $news->newsCategories()->sync($request->news_categories);
            if ($request->file('thumbnail')) {
                $file = $request->file('thumbnail');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/news'), $filename);

                if ($news->thumbnail && file_exists(public_path($news->thumbnail))) {
                    unlink(public_path($news->thumbnail));
                }
                $news->thumbnail = '/uploads/news/' . $filename;
                $news->save();
            }
            DB::commit();
            Session::flash('success', 'Thêm mới tin tức thành công');
            return redirect()->route('news.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Có lỗi khi tạo' . $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('chinh-sua-tin-tuc');
        $title = 'Chỉnh sửa tin tức';
        $news = News::findOrFail($id);
        $categories = NewsCategory::where('status', 1)->orderByDesc('id')->get();
        return view('admin.news.edit', compact('title', 'news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, string $id)
    {
        $this->authorize('chinh-sua-tin-tuc');
        $news = News::findOrFail($id);
        try {
            DB::beginTransaction();
            $news->update([
                'title' => $request->title,
                'slug' => Helper::createSlug($request->title),
                'content' => $request->content,
                'status' => $request->status,
            ]);
            $news->newsCategories()->sync($request->news_categories);
            if ($request->file('thumbnail')) {
                $file = $request->file('thumbnail');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/news'), $filename);

                if ($news->thumbnail && file_exists(public_path($news->thumbnail))) {
                    unlink(public_path($news->thumbnail));
                }
                $news->thumbnail = '/uploads/news/' . $filename;
                $news->save();
            }
            DB::commit();
            Session::flash('success', 'Cập nhật tin tức thành công');
            return redirect()->route('news.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Có lỗi khi chỉnh sửa');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-tin-tuc');
        $news = News::findOrFail($id);
        try {
            if ($news->thumbnail) {
                $thumnailPath = public_path($news->thumbnail);
                if (file_exists($thumnailPath)) {
                    unlink($thumnailPath);
                }
            }
            $news->delete();
            return response()->json(['success' => true, 'message' => 'Xóa tin tức thành công.']);
        } catch (\Exception $e) {
            return  response()->json(['success' => false, 'message' => 'Có lỗi khi xóa tin tức']);
        }
    }
}
