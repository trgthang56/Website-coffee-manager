<?php

namespace App\Http\Services\Menu;
use App\Models\Menu;
use Illuminate\Support\Facades\Session;
class MenuService{
    public function getParent(){
        return Menu::Where('parent_id',0)->get();
    }
    public function getAll(){
        return Menu::orderbyDesc('id')->paginate(20);
    }
    public function create($request){
        try {
         
            Menu::create([
                'name' => (string) $request->name,
                'parent_id' => (int) $request->parent_id,
                'description' => (string) $request->description,
                'content' => (string) $request->content,
                'active' => (int) $request->active
            ]);

        Session::flash('success', 'Tạo danh mục thành công');
        } catch (\Exception $th) {
           Session::flash('error', $th->getMessage());
           return false;
        }
        return true;
    }
    public function update($request,$menu) :bool
    {
        if($request->input('parent_id') != $menu->id){
            $menu->parent_id = (int) $request->input('parent_id');
        }
        $menu->name = (string) $request->input('name');
        $menu->description = (string) $request->input('description');
        $menu->content = (string) $request->input('content');
        $menu->active = (string) $request->input('active');
        $menu->save();

        Session::flash('success', 'Cập nhật danh mục thành công');
        return true;
    }
    public function destroy($request){
        $id = $request->input('id');
        $menu = Menu::Where('id',$request->input('id'))->first();
        if($menu){
            return Menu::Where('id',$id)->orWhere('parent_id',$id)->delete();
        }
        return false;
    }
}