<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderDetails;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Voucher;
use Illuminate\Support\Carbon;
use DateTime; 

class RevenueController extends Controller
{
    public function index(){
        $product = Product::all();
        $currentTime = time();

        // Tính timestamp của ngày 30 ngày trước
        $thirtyDaysAgoTimestamp = strtotime('-30 days', $currentTime);
        $todayTimestamp = strtotime('today', $currentTime);
      
        // Chuyển đổi timestamp thành định dạng ngày tháng cho SQL
        $thirtyDaysAgo = date('Y-m-d 00:00:00', $thirtyDaysAgoTimestamp);
        $today = date('Y-m-d 23:59:59', $todayTimestamp);
        // dd($product);
        $dates = [];
        $soLuongMon = [];
    
        $doanhThuNgay = [];
      $details = OrderDetails::where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->Where('status','Đã thanh toán')->get();
      foreach($product as $p){ $detailsCount = 0;
        foreach($details as $d){
            if($p->id == $d->product_id){
                $detailsCount += $d->qty;
            }
        }
        $soLuongMon[] = $detailsCount;
      }

      

for ($current_date = $thirtyDaysAgoTimestamp; $current_date <= $todayTimestamp; $current_date += 86400) {
    $dates[] = date('d/m/Y', $current_date);
    $count = 0;
    $orderTheoNgay = Order::whereDate('created_at',date('Y-m-d 00:00:00', $current_date))->Where('status','Đã thanh toán')->get();
    foreach($orderTheoNgay as $val){
   $count += $val->total;
}
   $doanhThuNgay[] = $count;
}
$dates[] = date('d/m/Y', $todayTimestamp);
$orderHomNay = Order::whereDate('created_at',date('Y-m-d', $todayTimestamp))->Where('status','Đã thanh toán')->get();
$homNay = 0;
foreach($orderHomNay as $val){
$homNay += $val->total;
}
$doanhThuNgay[] = $homNay;


   // Lấy các đơn hàng trong khoảng thời gian đã chỉ định và có trạng thái là 'Đã thanh toán'
   $orders = Order::where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->where('status', 'Đã thanh toán')->get();
  
                 

   $revenue = 0;
   $orderCount = Order::where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->Where('status','Đã thanh toán')->count();
   $orderCancleCount = Order::where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->Where('status','Đã hủy')->count();
   $orderCancle = Order::where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->Where('status','Đã hủy')->get();
   foreach($orders as $val){
        $revenue += $val->total;
   }
   $vnPay = Order::where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->Where('status','Đã thanh toán')->where('payMethod','Vn Pay')->count();
   $tienMat = Order::where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->Where('status','Đã thanh toán')->where('payMethod','Tiền mặt')->count();
   $userCount= User::where('created_at', '>=', $thirtyDaysAgo)->where('created_at', '<=', $today)->Where('status','active')->count();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.revenue.index',[
            'title' => 'Trang Thống Kê Doanh Thu',
            'users' => Auth::user(),
            'products' => $product,
            'orders' => $orders,
            'orderCancle' => $orderCancle,
            'revenue' => $revenue,
            'userCount' => $userCount,
            'orderCount' => $orderCount,
            'dates' => $dates,
            'doanhThuNgay' => $doanhThuNgay,
            'vnPay' => $vnPay,
            'tienMat' => $tienMat,
            'orderCancleCount' => $orderCancleCount,
            'soLuongMon' => $soLuongMon,
            'new' => $new,
            'newAll' => $newAll,
            'start_date' => date('d/m/Y', $thirtyDaysAgoTimestamp),
            'end_date' =>date('d/m/Y', $todayTimestamp)
        ]);
    }

public function searchRange(Request $request){
        $rangeDate = $request->date_range;
        $product = Product::all();
    // Tách khoảng thời gian thành thời điểm bắt đầu và kết thúc
    $dates1 = explode(' - ', $rangeDate);
    $startDate = date_create_from_format('d/m/Y', $dates1[0])->format('Y-m-d 00:00:00');// Thời điểm bắt đầu của ngày
    $endDate = date_create_from_format('d/m/Y', $dates1[1])->format('Y-m-d 23:59:59'); // Thời điểm kết thúc của ngày
    // $startDate = date('Y-m-d', $startDateString);
    // $endDate = date('Y-m-d', $endDateString);

     $dates = [];
        $soLuongMon = [];
        
        $doanhThuNgay = [];
      

        $details = OrderDetails::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->Where('status','Đã thanh toán')->get();
        
        foreach($product as $p){ $detailsCount = 0;
          foreach($details as $d){
              if($p->id == $d->product_id){
                  $detailsCount += $d->qty;
              }
          }
          $soLuongMon[] = $detailsCount;
        }

for ($current_date = strtotime($startDate); $current_date <= strtotime($endDate); $current_date += 86400) {
    $dates[] =  date('d/m/Y',$current_date);
    $count = 0;
    $orderTheoNgay = Order::whereDate('created_at', date('Y-m-d 00:00:00', $current_date))->Where('status','Đã thanh toán')->get();
    foreach($orderTheoNgay as $val){
   $count += $val->total;
}
   $doanhThuNgay[] = $count;
}




   // Lấy các đơn hàng trong khoảng thời gian đã chỉ định và có trạng thái là 'Đã thanh toán'
   $orders = Order::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('status', 'Đã thanh toán')->get();


   $revenue = 0;
   $orderCount = Order::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->Where('status','Đã thanh toán')->count();
   $orderCancleCount = Order::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->Where('status','Đã hủy')->count();
   $orderCancle = Order::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->Where('status','Đã hủy')->get();
   foreach($orders as $val){
        $revenue += $val->total;
   }
   $vnPay = Order::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->Where('status','Đã thanh toán')->where('payMethod','Vn Pay')->count();
   $tienMat = Order::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->Where('status','Đã thanh toán')->where('payMethod','Tiền mặt')->count();
   $userCount= User::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->Where('status','active')->count();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.revenue.index',[
            'title' => 'Kết Quả Tìm Kiếm Doanh Thu',
            'users' => Auth::user(),
            'products' => $product,
            'revenue' => $revenue,
            'userCount' => $userCount,
            'orderCount' => $orderCount,
            'orders' => $orders,
            'orderCancle' => $orderCancle,
            'dates' => $dates,
            'doanhThuNgay' => $doanhThuNgay,
            'vnPay' => $vnPay,
            'tienMat' => $tienMat,
            'orderCancleCount' => $orderCancleCount,
            'soLuongMon' => $soLuongMon,
            'new' => $new,
            'newAll' => $newAll,
            'start_date' => $dates1[0],
            'end_date' => $dates1[1]
        ]);
    }

    public function indexDay(){
        $product = Product::all();
        $currentTime = time();

        // Tính timestamp của ngày 30 ngày trước
    
        $todayTimestamp = strtotime('today', $currentTime);
      
        // Chuyển đổi timestamp thành định dạng ngày tháng cho SQL

        $today = date('Y-m-d 23:59:59', $todayTimestamp);
        // dd($product);
      
        $soLuongMon = [];
    
        $doanhThuNgay = [];
      $details = OrderDetails::whereDate('created_at',  $today)->Where('status','Đã thanh toán')->get();
      foreach($product as $p){ $detailsCount = 0;
        foreach($details as $d){
            if($p->id == $d->product_id){
                $detailsCount += $d->qty;
            }
        }
        $soLuongMon[] = $detailsCount;
      }

 





   // Lấy các đơn hàng trong khoảng thời gian đã chỉ định và có trạng thái là 'Đã thanh toán'
   $orders = Order::whereDate('created_at',$today)->where('status', 'Đã thanh toán')->get();
  
                 

   $revenue = 0;
   $orderCount = Order::whereDate('created_at',$today)->Where('status','Đã thanh toán')->count();
   $orderCancleCount = Order::whereDate('created_at',$today)->Where('status','Đã hủy')->count();
   $orderCancle = Order::whereDate('created_at',$today)->Where('status','Đã hủy')->get();
   foreach($orders as $val){
        $revenue += $val->total;
   }
   //lấy ngày hôm nay để gửi sang frontend
   $currentDate = new DateTime();
   $formattedDate = $currentDate->format('d-m-Y');
   $vnPay = Order::whereDate('created_at',$today)->Where('status','Đã thanh toán')->where('payMethod','Vn Pay')->count();
   $tienMat = Order::whereDate('created_at',$today)->Where('status','Đã thanh toán')->where('payMethod','Tiền mặt')->count();
   $userCount= User::whereDate('created_at',$today)->Where('status','active')->count();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.revenue.indexDay',[
            'title' => 'Trang Thống Kê Doanh Thu Theo Ngày',
            'users' => Auth::user(),
            'products' => $product,
            'revenue' => $revenue,
            'orders' => $orders,
            'orderCancle' => $orderCancle,
            'userCount' => $userCount,
            'orderCount' => $orderCount,
            'vnPay' => $vnPay,
            'tienMat' => $tienMat,
            'orderCancleCount' => $orderCancleCount,
            'soLuongMon' => $soLuongMon,
            'new' => $new,
            'newAll' => $newAll,
            'today' => $formattedDate
        ]);
    }

    public function searchDay(Request $request){
        $product = Product::all();
      

        // Tính timestamp của ngày 30 ngày trước
    
      
      
        // Chuyển đổi timestamp thành định dạng ngày tháng cho SQL

        $today = date_create_from_format('d-m-Y', $request->date)->format('Y-m-d');
        // dd($product);
      
        $soLuongMon = [];
    
        $doanhThuNgay = [];
      $details = OrderDetails::whereDate('created_at',  $today)->Where('status','Đã thanh toán')->get();
      foreach($product as $p){ $detailsCount = 0;
        foreach($details as $d){
            if($p->id == $d->product_id){
                $detailsCount += $d->qty;
            }
        }
        $soLuongMon[] = $detailsCount;
      }

 





   // Lấy các đơn hàng trong khoảng thời gian đã chỉ định và có trạng thái là 'Đã thanh toán'
   $orders = Order::whereDate('created_at',$today)->where('status', 'Đã thanh toán')->get();
  
                 

   $revenue = 0;
   $orderCount = Order::whereDate('created_at',$today)->Where('status','Đã thanh toán')->count();
   $orderCancleCount = Order::whereDate('created_at',$today)->Where('status','Đã hủy')->count();
   $orderCancle = Order::whereDate('created_at',$today)->Where('status','Đã hủy')->get();
   foreach($orders as $val){
        $revenue += $val->total;
   }
   $vnPay = Order::whereDate('created_at',$today)->Where('status','Đã thanh toán')->where('payMethod','Vn Pay')->count();
   $tienMat = Order::whereDate('created_at',$today)->Where('status','Đã thanh toán')->where('payMethod','Tiền mặt')->count();
   $userCount= User::whereDate('created_at',$today)->Where('status','active')->count();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.revenue.indexDay',[
            'title' => 'Kết Quả Tìm Kiếm Doanh Thu Theo Ngày',
            'users' => Auth::user(),
            'products' => $product,
            'revenue' => $revenue,
            'orders' => $orders,
            'orderCancle' => $orderCancle,
            'userCount' => $userCount,
            'orderCount' => $orderCount,
            'vnPay' => $vnPay,
            'tienMat' => $tienMat,
            'orderCancleCount' => $orderCancleCount,
            'soLuongMon' => $soLuongMon,
            'new' => $new,
            'newAll' => $newAll,
            'today' => $request->date
        ]);
    }

  
}
