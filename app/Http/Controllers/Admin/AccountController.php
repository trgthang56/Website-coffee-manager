<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

use App\Models\User;

class AccountController extends Controller
{
    //
    public function index()
    {
        $usersAll = User::Where('role','!=','5')->Where('role','!=','6')->Where('status','active')->get();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.listAcc', [
            'title' => 'Danh sách tài khoản',
            'userAll' => $usersAll,
            'users' => Auth::user(),
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required |unique:users|email',
            'password' => 'required|min:6|max:32',
            'confirm' => 'same:password',
            'phone' => 'required|digits:10'
        ]);
        if ($request->role === 'Quản lý') {
            $role = 1;
        } elseif ($request->role === 'Chạy bàn') {
            $role = 4;
        } elseif ($request->role === 'Thu ngân') {
            $role = 2;
        } elseif ($request->role === 'Pha chế') {
            $role = 3;
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $role,
            'phone_number' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->birth,
            'salary' => $request->salary,

        ]);
        return redirect()->route('listAcc')->with('success', 'Đã tạo tài khoản thành công');
    }

    
    function update_profile(Request $request)
    {

        $user = Auth::user();
        if (!empty($request->name)) {
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
        if (!empty($request->birth)) {
            $user->date_of_birth = $request->birth;
        }
        if (!empty($request->phone)) {
            $user->phone_number = $request->phone;
        }
        if (!empty($request->address)) {
            $user->address = $request->address;
        }
        $user->save();
        return redirect()->route('profile');
    }

    function logout()
    {
        Auth::logout();
        return redirect('admin/users/login/');
    }

    public function update_password(Request $request)
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
            return redirect()->route('profile')->with('success', 'Đã đổi mật khẩu thành công');
        } else {

            return redirect()->route('profile')->with('error', 'Mật khẩu cũ không đúng');
        }
    }
    public function deleteAcc($id)
    {

        $user = User::where('id', $id)->first();
        $user->status = 'Đã xóa';
        //Kiểm tra lệnh delete để trả về một thông báo
        $usersAll = User::all();
        if ($deleteData) {
            return redirect()->back()->with('success', 'Đã xóa tài khoản thành công');
        } else {
            return redirect()->back()->with('error', 'Xóa tài khoản không thành công vui lòng thử lại');
        }
    }

    public function searchAcc(Request $request)
    {

        $user = User::Where('name', 'like', '%' . $request->key . '%')
            ->orWhere('id', 'like', '%' . $request->key . '%')->Where('role','!=','5')->Where('role','!=','6')->Where('status','active')
            ->get();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.listAcc', [
            'title' => 'Danh sách tài khoản nhân viên',
            'userAll' => $user,
            'users' => Auth::user(),
            'new' => $new,
            'newAll'=> $newAll
        ]);
    }

    public function edit_profile(int $id){

        $user = User::Where('id',$id)->first();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.AccEdit', [
            'title' => 'Sửa thông tin tài khoản nhân viên',
            'user' => $user,
            'users' =>Auth::user(),
            'new' => $new,
            'newAll'=> $newAll
        ]);
    }

    public function edit_store(Request $request,int $id){
     
        $user = User::Where('id',$id)->first();
        if($user->email != $request->email){
            $this->validate($request, [        
                'email' => 'required |unique:users|email'
              
            ]);
        }
        $user->name = $request->name;
        $user->date_of_birth = $request->birth;
        $user->phone_number = $request->phone;
        $user->address = $request->address;
        if ($request->role === 'Quản lý') {
            $role = 1;
        } elseif ($request->role === 'Chạy bàn') {
            $role = 4;
        } elseif ($request->role === 'Thu ngân') {
            $role = 2;
        } elseif ($request->role === 'Pha chế') {
            $role = 3;
        }
         $user->role = $role;
         $user->email = $request->email;
         $user->salary = $request->salary;
         $user->save();
         return redirect()->route('listAcc')->with('success', 'Cập nhật tài khoản nhân viên thành công');
    }
    public function cusList(){
        $usersAll = User::Where('role','>','4')->Where('status','active')->get();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.customer.listAcc', [
            'title' => 'Danh sách tài khoản khách hàng',
            'userAll' => $usersAll,
            'users' => Auth::user(),
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function upgrade(int $id){
        $user = User::where('id', $id)->first();
        $user->role = '6';
        $user->save();
        return redirect()->back()->with('success', 'Đã nâng cấp tài khoản thành công');
    }
    public function resetPass(int $id){
        $user = User::where('id', $id)->first();
        $user->password = bcrypt('123456');
        $user->save();
        return redirect()->back()->with('success', 'Đã khôi phục mật khẩu thành công');
    }
}
