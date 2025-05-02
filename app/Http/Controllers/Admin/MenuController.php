<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuItemRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\NewsCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-menu');
        $title = 'Menu Site';
        $menus = Menu::with('items.children')->orderByDesc('id')->paginate(15);
        return view('admin.menu.list', compact('title', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-menu');
        $title = 'Thêm menu';
        return view('admin.menu.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('them-menu');
        $request->validate([
            'name' => 'required'
        ]);
        try {
            Menu::create(['name' => $request->name]);
            return redirect()->route('menu.index')->with('success', 'Thêm menu thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi khi thêm menu');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::with(['items.children'])->findOrFail($id);
        $menus = Menu::orderByDesc('id')->get();
        $modules = NewsCategory::where('status', 1)->orderByDesc('id')->get();
        $title = 'Quản lý site';
        return view('admin.menu.show', compact('title', 'menu', 'menus', 'modules'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('sua-menu');
        $menu = Menu::findOrFail($id);
        $title = 'Chỉnh sửa menu';
        return view('admin.menu.edit', compact('title', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('sua-menu');
        try {
            $menu = Menu::findOrFail($id);
            $request->validate([
                'name' => 'required'
            ]);
            $menu->update([
                'name' => $request->name
            ]);
            return redirect()->route('menu.index')->with('success', 'Sửa menu thành công');
        } catch (\Exception $e) {
            return redirect()->route('menu.index')->with('error', 'Sửa menu thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-menu');
        $menu = Menu::findOrFail($id);
        try {
            $menu->delete();
            return response()->json(['success' => true, 'message' => 'Xóa menu thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa menu vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa menu: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }

    public function destroy_menuItem(string $id)
    {
        $this->authorize('xoa-menu');
        $menuItem = MenuItem::findOrFail($id);
        try {
            $menuItem->delete();
            return response()->json(['success' => true, 'message' => 'Xóa menu thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa menu vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa menu: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }

    public function create_menu_item(MenuItemRequest $request)
    {
        try {
            MenuItem::create([
                'menu_id' => $request->menu_id,
                'title' => $request->title,
                'parent_id' => $request->parent_id,
                'url' => $request->url
            ]);
            return redirect()->back()->with('success', 'Thêm mục menu thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi khi thêm' . $e->getMessage());
        }
    }

    public function update_menu_item(MenuItemRequest $request, $parent)
    {
        try {
            $menuItem = MenuItem::findOrFail($parent);
            $menuItem->update([
                'menu_id' => $request->menu_id,
                'title' => $request->title,
                'parent_id' => $request->parent_id,
                'url' => $request->url
            ]);
            return redirect()->back()->with('success', 'Cập nhật mục menu thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi khi cập nhật' . $e->getMessage());
        }
    }

    public function edit_menu_item($id, $parent)
    {
        $menu = Menu::with(['items.children'])->findOrFail($id);
        $editItem = MenuItem::findOrFail($parent);
        $modules = NewsCategory::where('status', 1)->orderByDesc('id')->get();
        $title = 'Edit menu item';
        return view('admin.menu.show', compact('title', 'menu', 'editItem', 'modules'));
    }

    public function edit_menu_item_children($id, $parent, $children)
    {
        $menu = Menu::with(['items.children'])->findOrFail($id);
        $menu_item = MenuItem::findOrFail($parent);
        $editItem = MenuItem::findOrFail($children);
        $modules = NewsCategory::where('status', 1)->orderByDesc('id')->get();
        $title = 'Edit menu item';
        return view('admin.menu.menu-item', compact('title', 'menu', 'editItem', 'menu_item', 'modules'));
    }

    public function menu_items($id, $parent_id)
    {
        $menu = Menu::findOrFail($id);
        $menu_item = MenuItem::with('children')->findOrFail($parent_id);
        $modules = NewsCategory::where('status', 1)->orderByDesc('id')->get();
        $title = 'Quản lý site';
        return view('admin.menu.menu-item', compact('title', 'menu', 'menu_item', 'modules'));
    }
}
