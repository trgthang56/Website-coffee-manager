<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\Attendance;
use App\Models\Order;
use App\Events\Checkin;
use App\Events\Checkout;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function listConfirm(){
        $attendances = Attendance::with(['user'])->whereNull('check_out_time')->Where('status','Chưa hoàn thành')->orderBy('id', 'desc')->get();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.attendances.confirm', [
            'title' => 'Danh sách chấm công vào chưa hoàn thành',
            'users' => Auth::user(),
            'attendances' => $attendances,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function listConfirmOut(){
        $attendances = Attendance::with(['user'])->whereNotNull('check_out_time')->Where('status','Chưa xác nhận')->get();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.attendances.confirmout', [
            'title' => 'Danh sách chấm công ra chưa xác nhận',
            'users' => Auth::user(),
            'attendances' => $attendances,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function checkin(Request $request){
     $user = Auth::user();
     $currentDate = date('Y-m-d');
     $currentTime = date('H:i:s');
     $check = Attendance::Where('user_id',$user->id)->whereNull('check_out_time')->WhereDate('created_at',$currentDate)->first();
     if($check){
         return \redirect()->back()->with('error','Bạn chưa kết thúc giờ làm việc hôm nay !');
     }
     Attendance::create([
        'user_id' => $user->id,
        'work_date' => $currentDate,
        'status' => 'Chưa hoàn thành',
        'check_in_time' => $currentTime
     ]);
     $dataArray = [
        $user->id          
    ];  
    Notification::create([
        'user_id' => $user->id,
        'content' =>  $user->name." chấm công !",
        'read_by'  => $dataArray
    ]);
    broadcast(new Checkin($user));
    return \redirect()->back()->with('success','Đã chấm công cho bạn thành công');
    }


    public function checkout(Request $request){
        $user = Auth::user();
        $currentDate = date('Y-m-d');
       
        $check = Attendance::Where('user_id',$user->id)->Where('status','Chưa hoàn thành')->WhereDate('created_at',$currentDate)->first();
        if(empty($check)){
            return \redirect()->back()->with('error','Bạn chưa bắt đầu làm việc hôm nay !');
        }
        $currentTime = date('H:i:s');
        $carbonTime1 = Carbon::createFromTimeString($check->check_in_time);
        $carbonTime2 = Carbon::createFromTimeString($currentTime);
// Tính khoảng cách giữa hai thời điểm (dưới dạng giây)
    $hoursDifference = $carbonTime2->diffInMinutes($carbonTime1) / 60; 
    $formattedHours = number_format($hoursDifference, 2, '.', '');
      
        $check->check_out_time = $currentTime;
       $check->total_hours = $formattedHours;
        $check->status = 'Chưa xác nhận';
        $check->save();
        $dataArray = [
            $user->id          
        ];  
        Notification::create([
            'user_id' => $user->id,
            'content' =>  $user->name." kết thúc làm!",
            'read_by'  => $dataArray
        ]);
        broadcast(new Checkout($user));
        return \redirect()->back()->with('success','Đã chấm công cho bạn thành công');
    }
    public function edit(int $id){
        $att = Attendance::with(['user'])->Where('id',$id)->first();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.attendances.edit', [
            'title' => 'Danh sách chấm công ra chưa xác nhận',
            'users' => Auth::user(),
            'att' => $att,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function editStore(Request $request,int $id){
        $att = Attendance::with(['user'])->Where('id',$id)->first();
        $att->check_in_time = $request->checkin;
        $att->check_out_time = $request->checkout;
        $carbonTime1 = Carbon::createFromTimeString( $request->checkin);
        $carbonTime2 = Carbon::createFromTimeString($request->checkout);
// Tính khoảng cách giữa hai thời điểm (dưới dạng giây)
    $hoursDifference = $carbonTime2->diffInMinutes($carbonTime1) / 60; 
    $formattedHours = number_format($hoursDifference, 2, '.', '');
    $att->total_hours = $formattedHours;
    $att->save();
    return \redirect()->back()->with('success','Đã cập nhật thông tin thành công');
    }

    public function destroy(int $id){
        $deleteData = Attendance::where('id', $id)->delete();
        if ($deleteData) {
            return \redirect()->route('voucher/list')->with('success', 'Đã xóa chấm công thành công');
        } else {
            return \redirect()->route('voucher/list')->with('error', 'Xóa chấm công không thành công vui lòng thử lại');
        }
    }

    public function confirmStore(int $id){
        $att = Attendance::with(['user'])->Where('id',$id)->first();
        $att->status = 'Đã hoàn thành';
        $att->save();
        return \redirect()->back()->with('success','Đã xác nhận thông tin thành công');
    }
    public function confirmAll(){
        $attendances = Attendance::with(['user'])->whereNotNull('check_out_time')->Where('status','Chưa xác nhận')->get();
        foreach($attendances as $att){
            $att->status = 'Đã hoàn thành';
            $att->save();
        }
  
        return \redirect()->back()->with('success','Đã xác nhận tất cả thành công');
    }
    public function reportSalary(){

    
        $listUser = User::Where('role','!=','1')->where('role','!=','0')->where('role','!=','5')->where('role','!=','6')->get(); 
        $currentTime = time();
        // Tính timestamp của ngày 30 ngày trước
        $thirtyDaysAgoTimestamp = strtotime('-6 days', $currentTime);
        $todayTimestamp = strtotime('today', $currentTime);
      
        // Chuyển đổi timestamp thành định dạng ngày tháng cho SQL
        $thirtyDaysAgo = date('Y-m-d 00:00:00', $thirtyDaysAgoTimestamp);
        $today = date('Y-m-d 23:59:59', $todayTimestamp);
        // dd($product);
       
        $attendances = Attendance::with(['user'])->where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->Where('status','Đã hoàn thành')->get();
        $order = Order::where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->Where('status','Đã thanh toán')->get();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.attendances.report', [
            'title' => 'Danh sách lương nhân viên',
            'users' => Auth::user(),
            'attendances' => $attendances,
            'listUser' => $listUser,
            'order' => $order,
            'new' => $new,
            'newAll' => $newAll,
            'start_date' => date('d/m/Y', $thirtyDaysAgoTimestamp),
            'end_date' =>date('d/m/Y', $todayTimestamp)
        ]);
    }

    public function searchRange(Request $request){
       
        $listUser = User::Where('role','!=','1')->where('role','!=','0')->where('role','!=','5')->where('role','!=','6')->get(); 
        $rangeDate = $request->date_range;
    // Tách khoảng thời gian thành thời điểm bắt đầu và kết thúc
    $dates1 = explode(' - ', $rangeDate);
    $startDate = date_create_from_format('d/m/Y', $dates1[0])->format('Y-m-d 00:00:00');// Thời điểm bắt đầu của ngày
    $endDate = date_create_from_format('d/m/Y', $dates1[1])->format('Y-m-d 23:59:59'); // Thời điểm kết thúc của ngày

    // $startDate = date('Y-m-d', $startDateString);
    // $endDate = date('Y-m-d', $endDateString);
        $attendances = Attendance::with(['user'])->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->Where('status','Đã hoàn thành')->get();
        $order = Order::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->Where('status','Đã thanh toán')->get();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.attendances.report', [
            'title' => 'Danh sách lương nhân viên',
            'users' => Auth::user(),
            'attendances' => $attendances,
            'listUser' => $listUser,
            'order' => $order,
            'new' => $new,
            'newAll' => $newAll,
            'start_date' => $dates1[0],
            'end_date' => $dates1[1]
        ]);
    }


    public function showAtt(int $id){
        $user = User::Where('id',$id)->first();
        $currentTime = time();
        // Tính timestamp của ngày 30 ngày trước
        $thirtyDaysAgoTimestamp = strtotime('-6 days', $currentTime);
        $todayTimestamp = strtotime('today', $currentTime);
      
        // Chuyển đổi timestamp thành định dạng ngày tháng cho SQL
        $thirtyDaysAgo = date('Y-m-d 00:00:00', $thirtyDaysAgoTimestamp);
        $today = date('Y-m-d 23:59:59', $todayTimestamp);
        $attendances = Attendance::with(['user'])->Where('user_id',$id)->where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->Where('status','Đã hoàn thành')->get();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.attendances.list', [
            'title' => 'Chi tiết chấm công nhân viên '.$user->name,
            'users' => Auth::user(),
            'user' => $user,
            'attendances' => $attendances,
            'new' => $new,
            'newAll' => $newAll,
            'start_date' => date('d/m/Y', $thirtyDaysAgoTimestamp),
            'end_date' =>date('d/m/Y', $todayTimestamp)
        ]);
    }
    public function searchRangeShow(Request $request,int $id){
        $user = User::Where('id',$id)->first();
        $rangeDate = $request->date_range;
    // Tách khoảng thời gian thành thời điểm bắt đầu và kết thúc
    $dates1 = explode(' - ', $rangeDate);
    $startDate = date_create_from_format('d/m/Y', $dates1[0])->format('Y-m-d 00:00:00');// Thời điểm bắt đầu của ngày
    $endDate = date_create_from_format('d/m/Y', $dates1[1])->format('Y-m-d 23:59:59'); // Thời điểm kết thúc của ngày
        $attendances = Attendance::with(['user'])->Where('user_id',$id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->Where('status','Đã hoàn thành')->get();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.attendances.list', [
            'title' => 'Chi tiết chấm công nhân viên '.$user->name,
            'users' => Auth::user(),
            'user' => $user,
            'attendances' => $attendances,
            'new' => $new,
            'newAll' => $newAll,
            'start_date' => $dates1[0],
            'end_date' => $dates1[1]
        ]);
    }
    public function exporttoPDF(Request $request){

        $user = User::Where('id',$request->user_id)->first();
         $pdf = PDF::loadView('admin.attendances.exportPDF',[   'users' => Auth::user(),
         'title' => 'Chi tiết đơn hàng',
         'user' => $user,
         'attendances' => json_decode($request->attendances),
       ])->setOptions(['defaultFont' => 'fontMetrics']);
       return   $pdf->download('attendance.pdf');
    }
}
