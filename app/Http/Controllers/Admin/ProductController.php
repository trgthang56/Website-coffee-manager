<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Menu\MenuService;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {   $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.product.list', [
            'title' => 'Danh sách đồ uống',
            'users' => Auth::user(),
            'menus' => $this->menuService->getAll(),
            'product' => Product::with('menu')->orderByDesc('id')->paginate(15),
            'new' => $new,
            'newAll' => $newAll
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.product.add', [
            'title' => 'Thêm đồ uống',
            'users' => Auth::user(),
            'menus' => $this->menuService->getAll(),
            'new' => $new,
            'newAll' => $newAll
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */



    public function store(Request $request)
    {
        if (!empty($request->image)) {
            $request->validate([
                'image' => 'image| mimes:jpeg,png,jpg,giv,svg| max:2048'
            ]);
        }
        if (
            $request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') >= $request->input('price')
        ) {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc');
            return redirect()->back();
        }

        if ($request->input('price_sale') != 0 && (int)$request->input('price') == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return redirect()->back();
        }
        $image_name = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('upload'), $image_name);
        $path = "upload/" . $image_name;
        Product::create([
            'name' => (string) $request->name,
            'description' => (string) $request->description,
            'content' => (string) $request->content,
            'menu_id' => (int) $request->menu_id,
            'price' => (int) $request->price,
            'price_sale' => (int) $request->price_sale,
            'active' => (int) $request->active,
            'thumb' => (string) $path
        ]);

        return redirect()->back()->with('success', 'Đã tạo sản phẩm  thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product = Product::Where('id', $id)->first();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.product.edit', [
            'title' => 'Sửa đồ uống: ' . $product->name,
            'users' => Auth::user(),
            'menus' => Menu::where('active', 1)->get(),
            'product' => $product,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    protected function isValidPrice($request)
    {
        if (
            $request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') >= $request->input('price')
        ) {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc');
            return false;
        }

        if ($request->input('price_sale') != 0 && (int)$request->input('price') == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return false;
        }

        return  true;
    }

    public function update(Request $request, int $id)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) return \redirect()->back();

        $product = Product::Where('id', $id)->first();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->content = $request->content;
        $product->menu_id = $request->menu_id;
        $product->price = $request->price;
        $product->price_sale = $request->price_sale;
        $product->active = $request->active;
        if (!empty($request->image)) {
            $request->validate([
                'image' => 'image| mimes:jpeg,png,jpg,giv,svg| max:2048'
            ]);
            $image_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload'), $image_name);
            $path = "upload/" . $image_name;
            $product->thumb = (string) $path;
        }
        $product->save();
        Session::flash('success', 'Cập nhật thành công');

        return redirect()->route('product/list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $deleteData = DB::table('products')->where('id', '=', $id)->delete();
        if ($deleteData) {
            return \redirect()->route('product/list')->with('success', 'Đã xóa đồ uống thành công');
        } else {
            return \redirect()->route('product/list')->with('error', 'Xóa đồ uống không thành công vui lòng thử lại');
        }
    }
}
