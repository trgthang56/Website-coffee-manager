<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Menu\MenuService;
use App\Models\Menu;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class VoucherController extends Controller
{
    public function index()
    {   $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.voucher.add', [
            'title' => 'Tạo mã khuyến mãi',
            'users' => Auth::user(),
            'new' => $new,
            'newAll' => $newAll
        ]);
    }

    public function indexList()
    {   
        $vouchers =Voucher::orderBy('id', 'desc')->get();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.voucher.list', [
            'title' => 'Danh sách mã khuyến mãi',
            'users' => Auth::user(),
            'vouchers' => $vouchers,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }

    public function show(int $id)
    {   
        $voucher = Voucher::Where('id',$id)->first();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.voucher.edit', [
            'title' => 'Sửa mã khuyến mãi',
            'users' => Auth::user(),
            'voucher'=> $voucher,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }

    public function generateRandomVoucherCode($voucherId)
    {  
        $length = 6;
        // Tạo một chuỗi ngẫu nhiên có độ dài cho trước
        $randomString = Str::random($length);
    
        // Kết hợp ID của voucher và chuỗi ngẫu nhiên
        $voucherCode = $randomString . $voucherId;
    
        return $voucherCode;
    }

    public function update(Request $request,int $id){
        $voucher = Voucher::Where('id',$id)->first();
        $voucher->value = $request->value;
        $voucher->condition = $request->condition;
        $voucher->expiry_date = $request->expiry_date;
        if(!empty($request->image) ){
            $request->validate([
                'image' => 'image| mimes:jpeg,png,jpg,giv,svg| max:2048'
            ]);
            $image_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload'), $image_name);
            $path = "upload/" . $image_name;
            $voucher->image = (string) $path;
        }
        $voucher->save();
        return redirect()->route('voucher/list')->with('success', 'Đã cập nhật chi tiết voucher');
    }
    public function store(Request $request)
    {   
        // $voucherCode = $this->generateRandomVoucherCode($length);
        
        if($request->user === 'Tất cả người dùng'){
            $user = User::all();
            $currentDate = Carbon::now()->day;
            $request->validate([
                'image' => 'image| mimes:jpeg,png,jpg,giv,svg| max:2048'
            ]);
            $image_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload'), $image_name);
            $path = "upload/" . $image_name;
            foreach($user as $val ){
                $voucher = new Voucher();
                $currentDate += $val->id;
                $voucherCode = $this->generateRandomVoucherCode($currentDate);
                $voucher->code = $voucherCode;
                $voucher->value = $request->value;
                $voucher->expiry_date = $request->expiry_date;
                $voucher->user_role = $val->role;
                $voucher->status = 'Chưa dùng';
                $voucher->condition = $request->condition;    
                $voucher->image = (string) $path;
                $voucher->user_id = $val->id;
                $voucher->save();
            }
        }
        else if($request->user === 'Khách hàng tiềm năng'){
            $user = User::Where('role','5')->get();
            $currentDate = Carbon::now()->day;
            $request->validate([
                'image' => 'image| mimes:jpeg,png,jpg,giv,svg| max:2048'
            ]);
            $image_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload'), $image_name);
            $path = "upload/" . $image_name;
            foreach($user as $val ){
                $voucher = new Voucher();
                $currentDate += $val->id;
                $voucherCode = $this->generateRandomVoucherCode($currentDate);
                $voucher->code = $voucherCode;
                $voucher->value = $request->value;
                $voucher->expiry_date = $request->expiry_date;
                $voucher->user_role = $val->role;
                $voucher->status = 'Chưa dùng';
                $voucher->condition = $request->condition;
              
                $voucher->image = (string) $path;
                $voucher->user_id = $val->id;
                $voucher->save();
            }

        }
        else if($request->user === 'Khách hàng vip'){
           $user = User::Where('role','6')->get();
           $currentDate = Carbon::now()->day;
           $request->validate([
            'image' => 'image| mimes:jpeg,png,jpg,giv,svg| max:2048'
        ]);
        $image_name = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('upload'), $image_name);
        $path = "upload/" . $image_name;
           foreach($user as $val ){
            $voucher = new Voucher();
            $currentDate += $val->id;
            $voucherCode = $this->generateRandomVoucherCode($currentDate);
            $voucher->code = $voucherCode;
            $voucher->value = $request->value;
            $voucher->expiry_date = $request->expiry_date;
            $voucher->user_role = $val->role;
            $voucher->status = 'Chưa dùng';
            $voucher->condition = $request->condition;
          
            $voucher->image = (string) $path;
            $voucher->user_id = $val->id;
            $voucher->save();
        }
        }
        else if($request->user === 'Nhân viên cửa hàng'){
            $user = User::Where('role','!=','5')->Where('role','!=','6')->get();
            $currentDate = Carbon::now()->day;
            $request->validate([
                'image' => 'image| mimes:jpeg,png,jpg,giv,svg| max:2048'
            ]);
            $image_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload'), $image_name);
            $path = "upload/" . $image_name;
            foreach($user as $val ){
                $voucher = new Voucher();
                $currentDate += $val->id;
                $voucherCode = $this->generateRandomVoucherCode($currentDate);
                $voucher->code = $voucherCode;
                $voucher->value = $request->value;
                $voucher->expiry_date = $request->expiry_date;
                $voucher->user_role = $val->role;
                $voucher->status = 'Chưa dùng';
                $voucher->condition = $request->condition;
                $voucher->image = (string) $path;
                $voucher->user_id = $val->id;
                $voucher->save();

            }
        }
        return redirect()->back()->with('success', 'Đã tạo voucher thành công');
    }
    
    public function destroy(int $id)
    {
        $deleteData = Voucher::where('id', $id)->delete();
        if ($deleteData) {
            return \redirect()->route('voucher/list')->with('success', 'Đã xóa voucher thành công');
        } else {
            return \redirect()->route('voucher/list')->with('error', 'Xóa voucher không thành công vui lòng thử lại');
        }
    }
    public function check(Request $request){
        $voucher = Voucher::Where("code",$request->code)->first();
        $ngayThangNamHienTai = Carbon::now()->toDateString();
        $thoiDiemCarbon = Carbon::parse($voucher->expiry_date);

        if(empty($voucher)){
            return response()->json([
                'error' => true ,
                'status' => 'Mã voucher không tồn tại'           
            ]);
        }else if($ngayThangNamHienTai > $thoiDiemCarbon->toDateString()){
            return response()->json([
                'error' => true ,
                'status' => 'Mã voucher đã hết hạn'           
            ]);
        }else if($voucher->condition > $request->total){
            $formattedNumber1 = number_format($voucher->condition);
            return response()->json([
                'error' => true ,
                'status' => 'Voucher chỉ áp dụng cho đơn hàng có giá từ '.$formattedNumber1.' đ'         
            ]);
        }else if($voucher->status === 'Đã sử dụng'){
            return response()->json([
                'error' => true ,
                'status' => 'Voucher đã được sử dụng'        
            ]);
        }else{
            $formattedNumber1 = number_format($voucher->value);
            return response()->json([
                'error' => false ,
                'status' => 'Áp mã voucher thành công được giảm '.$formattedNumber1.' đ',
                'voucher' => $voucher         
            ]);
        }
    }
}
