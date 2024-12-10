<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

use App\Models\User;


class CusAccountController extends Controller
{
    public function store(Request $request,int $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required |unique:users|email',
            'password' => 'required|min:6|max:32',
            'confirm' => 'same:password'
        ]);
       
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => '5'
        ]);
        return redirect()->back()->with('success', 'Đã tạo tài khoản thành công');
    }
    public function login(Request $request,int $id ){
        
        $this->validate($request, [
            'email' => 'required | email:filter',
            'password' => 'required '
        ]);

        if(Auth::attempt(['email' => $request->input('email'), 
        'password' => $request->input('password')
        
    ], $request->input('remember') )){
        return redirect()->route('profile/cus',[
            'id' => $id
        ]);
        }

       Session::flash('error','Email hoặc mật khẩu không đúng');
        return  redirect()->back();
    }

    function logout(int $id)
    {
        Auth::logout();
        return redirect()->route('login/cus',[
            'id' => $id
        ]);
    }

    function update_profile(Request $request,int $id)
    {
    $data = $request->all();
  
       if(!empty($request->name)&& !empty($request->image)){
        $user = Auth::user();
        if (!empty($request->name) ) {
            $user->name = $request->name;
        }
        if (!empty($request->image)) {
            $request->validate([
                'image' => 'image| mimes:jpeg,png,jpg,giv,svg| max:2048'
            ]);
            $image_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('template/admin/profile'), $image_name);
            $path = "/template/admin/profile/" . $image_name;
            $user->image = $path;
        }
        $user->save();
        return redirect()->back()->with('success', 'Đã cập nhật thông tin thành công');
       }else{
        return redirect()->back();
       }
   
    }

    public function update_password(Request $request,int $id)
    {
        $this->validate($request, [
            'password' => 'required|min:6|max:32',
            'password1' => 'required|min:6|max:32',
            'confirm' => 'same:password1'
        ]);
        $user = Auth::user();
        if (Hash::check($request->password, $user->password)) {
            $user->password = bcrypt($request->password1);
            $user->save();
            return redirect()->back()->with('success', 'Đã đổi mật khẩu thành công');
        } else {

            return redirect()->back()->with('error', 'Mật khẩu cũ không đúng');
        }
    }
    public function loveList(Request $request){
       $data = $request->all();   
      if(Auth::check()){
        $user = Auth::user();
        $loveList = $user->getAttribute('loveList');
        $id = (int) $data['product_id'];
        if($user->loveList == null){
            $loveList[] = $id;
            $user->setAttribute('loveList', $loveList);
            $user->save();
        //     if($user->loveList == null){
        //         $dataArray = [
        //             (int) $data['product_id']       
        //         ];  
        //         $user->loveList = $dataArray;
        //         $user->save();
        //     }
        //    else{
        //     $id = (int) $data['product_id'];
        //     array_push($user->loveList , $id);
        //     $user->save();
        //    }
           
            return response()->json([
                'error' => false 
                      
            ]);
        }else{
            if(in_array($id, $loveList)){
                return response()->json([
                    'error' => 1
                          
                ]);
            }else{
                $loveList[] = $id;
                $user->setAttribute('loveList', $loveList);
                $user->save();
            //     if($user->loveList == null){
            //         $dataArray = [
            //             (int) $data['product_id']       
            //         ];  
            //         $user->loveList = $dataArray;
            //         $user->save();
            //     }
            //    else{
            //     $id = (int) $data['product_id'];
            //     array_push($user->loveList , $id);
            //     $user->save();
            //    }
               
                return response()->json([
                    'error' => false 
                          
                ]);
            }
        }
       
      
      
      }else{
        return response()->json([
            'error' => true 
                  
        ]);
      }
        
    }
}
