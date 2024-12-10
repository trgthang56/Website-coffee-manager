<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Menu\MenuService;
use App\Models\Menu;
use App\Models\Notification;

class MenuController extends Controller
{

    public function __construct(MenuService $menuService){
        $this->menuService = $menuService;
    }


    public function create(){
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.menu.add',[
        'title' => 'Thêm Danh Mục Mới',
        'users' => Auth::user(),
        'menus' => $this->menuService->getParent(),
            'new' => $new,
            'newAll' => $newAll
        ]);
    }

    public function update(Menu $menu, CreateFormRequest $request){
        $this->menuService->update($request,$menu);
        return redirect()->route('menus/list');
    }
    public function store(CreateFormRequest $request){
        $result = $this->menuService->create($request);
        return redirect()->back();
    }
    public function index(){
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.menu.list',[
            'title' => 'Danh sách danh mục',
            'users' => Auth::user(),
            'menus' => $this->menuService->getAll(),
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function show(Menu $menu){
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.menu.edit',[
            'title'=> 'Chỉnh sửa danh mục: '.$menu->name,
            'menu' =>$menu,
            'users' => Auth::user(),
          'menus' => $this->menuService->getParent(),
          'new' => $new,
          'newAll' => $newAll
        ]);
    }
    public function destroy(Request $request){
        $result = $this->menuService->destroy($request);
        if($result){
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công danh mục'
            ]);
        }
        return response()->json([
            'error' => true,
           
        ]);
    }
}
