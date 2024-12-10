<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;


class MainController extends Controller
{
    //
    public function index(){
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
      $chuaDoc= array();
      $user = Auth::user();
        foreach($newAll as $val){
         if(!in_array($user->id, $val->read_by)){
            array_push($chuaDoc, $val);
         }
        };
       
        if(!empty($chuaDoc)){
            foreach($chuaDoc as $val1){
                $val1->read_by = array_merge($val1->read_by, [$user->id]);
                $val1->save();
            }
        }
    return view('admin.home',[
        'title' => 'Trang Quản Trị',
        'users' => Auth::user(),
        'new' => $new,
        'newAll' => $newAll
    ]);
 
      
    }
}
