<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\Notification;

class TableController extends Controller
{
  public  function index()
    {
        $tables =  DB::table('tables')->paginate(10);
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.table.list', [
            'title' => 'Danh sách bàn',
            'users' => Auth::user(),
            'tables' => $tables,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function create()
    {   $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.table.add',[
            'title' => 'Tạo bàn mới',
            'users' => Auth::user(),
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function store(Request $request){
        Table::create([
            'name' => $request->name,
            'location' => $request->location
        ]);
       session::flash('success', 'Đã tại bàn thành công');
        return \redirect()->route('tables/list');
    }
    public function show( int $id){
       $tables = Table::Where('id',$id)->first();
       $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
       $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.table.edit',[
            'title' => 'Cập nhật bàn',
            'users' => Auth::user(),
            'tables' => $tables,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function update(Request $request,int $id){
        $tables = Table::Where('id', $id)->first();
        $tables->name = $request->name;
        $tables->location = $request->location;
        $tables->save();
        Session::flash('success', 'Cập nhật thành công');
        return redirect()->route('tables/list');
    }

    public function destroy(int $id)
    {
        $deleteData = DB::table('tables')->where('id', '=', $id)->delete();
        if ($deleteData) {
            return \redirect()->route('tables/list')->with('success', 'Đã xóa bàn thành công');
        } else {
            return \redirect()->route('tables/list')->with('error', 'Xóa bàn không thành công vui lòng thử lại');
        }
    }
}
