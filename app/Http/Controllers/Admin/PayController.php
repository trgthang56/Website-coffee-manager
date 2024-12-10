<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Notification;
use App\Events\NewOrder;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Broadcast;
use App\Events\updateDetail;
use App\Events\finishDetail;
use App\Events\deleteDetail;
use App\Events\deleteAllDetail;
use App\Events\cancleOrder;
use App\Events\finishAllDetail;
use App\Events\payOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use App\Models\Voucher;

class PayController extends Controller
{
    public function index(){
      
        $orderFinish = Order::whereHas('OrderDetails', function ($query) {
            $query->where('status', 'Đã trả đồ');
        })->orderBy('id','ASC')->paginate(15);
        
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
         return view('admin.Pay.bill', [
             'users' => Auth::user(),
             'title' => 'Danh sách đơn hàng chưa thanh toán',
             'orderNew' => $orderFinish,
             'new' => $new,
             'newAll' => $newAll
         ]);
    }
    public function showDetails(int $id){
        $details = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Đã trả đồ')->orderBy('id','ASC')->paginate(15);
        $details1 = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Đã trả đồ')->orderBy('id','ASC')->get();
        $total = 0;
        foreach($details1 as $val){
            $total += $val->price;
        }
        $order = Order::with(['user','table'])->where('id',$id)->first();
        $doDaTra = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Đã trả đồ')->count();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.Pay.detail', [
            'users' => Auth::user(),
            'title' => 'Chi tiết đơn hàng',
            'details' => $details,
            'detailAll' => $details1,
            'order' => $order,
            'total' => $total,
            'doDaTra' => $doDaTra,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function exporttoPDF(Request $request){
      $data = $request->all();
       $details = OrderDetails::with(['order','product'])->where('order_id',$data['id'] )->where('status','Đã thanh toán')->get();
        
        $order = Order::with(['user','table','voucher'])->where('id',$data['id'])->first();
        $pdf = PDF::loadView('admin.Pay.exportPDF',[   'users' => Auth::user(),
        'title' => 'Chi tiết đơn hàng',
        'order' => $order,
        'detailAll' => $details
      ])->setOptions(['defaultFont' => 'fontMetrics']);
      return   $pdf->download('bill.pdf');
    }
   
    public function payment(Request $request){$data = $request->all();
        if($data['method'] === '3'){
            $order = Order::with(['user','table'])->where('id',$data['id'] )->Where('status','Chưa thanh toán')->first();
        $details = OrderDetails::with(['order','product'])->where('order_id',$data['id'] )->where('status','Đã trả đồ')->get();
        if(empty($order) || empty($details)){
            return redirect()->route('bill/list/')->with('error', 'Thanh toán không thành công');
        }
        foreach($details as $val){
            $val->status = 'Đã thanh toán';
            $product = Product::where('id',$val->product_id)->first();
            if(!empty($product->sale_count)){
                $product->sale_count += $val->qty;
            }else{
                $product->sale_count = $val->qty;
            }
            $product->save();
            $val->save();
        }
        $order->payBy = Auth::user()->id;
        $order->payMethod = 'Tiền mặt';
        $order->price = $data['total'] ;
        $order->discount = $data['sale'];
        $order->total = $data['total'] - $data['sale'];
        if(!empty($data['voucher'])){
            $voucher = Voucher::Where("code",$data['voucher'])->Where('status','Chưa dùng')->first();
            $voucher->status = 'Đã sử dụng';
            $voucher->save();
            $order->total = $data['total'] - $data['sale'] - $voucher->value;
            $order->code = $voucher->id;
            $order->discount = $data['sale'] + $voucher->value;
        }  
        $order->status = 'Đã thanh toán';

        $order->save();
        $table = Table::Where("id",$order->table->id)->first();
        $table->status = "";
        $table->save();
 
        $dataArray = [
            Auth::user()->id       
        ]; 
        Notification::create([
            'user_id' => Auth::user()->id,
            'content' =>  "Thanh toán đơn số ".$order->id,
            'read_by'  => $dataArray
        ]);
        broadcast(new payOrder($order,Auth::user()->id));
        $pdf = PDF::loadView('admin.Pay.exportPDF',[   'users' => Auth::user(),
        'title' => 'Chi tiết đơn hàng',
        'detailAll' => $details,
        'order' => $order,
        'total' => $order->price,
        'amout' => $order->total
      ])->setOptions(['defaultFont' => 'fontMetrics']);
        // return $pdf->download('bill.pdf');
        return redirect()->route('revenue/list/')->with('success', 'Thanh toán thành công đơn '.$order->id);
        }else if($data['method'] === '1'){
            $order = Order::with(['user','table'])->where('id',$data['id'] )->Where('status','Chưa thanh toán')->first();
        $details = OrderDetails::with(['order','product'])->where('order_id',$data['id'] )->where('status','Đã trả đồ')->get();
        if(empty($order) || empty($details)){
            return redirect()->route('bill/list/')->with('error', 'Thanh toán không thành công');
        }
      
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://127.0.0.1:8000/pay/checkout/";
$vnp_TmnCode = "WO74TBL4";//Mã website tại VNPAY 
$vnp_HashSecret = "UZCFZAHOFNQAJKIRROEBXJKAWOKJKBUU"; //Chuỗi bí mật

$vnp_TxnRef =$data['id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
$vnp_OrderInfo = 'Thanh toán đơn hàng số '.$data['id'];
$vnp_OrderType = 'billpayment';
$vnp_Amount = ($data['total'] - $data['sale']) * 100;
$vnp_Locale = 'vn';

$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
//Add Params of 2.0.1 Version
// $vnp_ExpireDate = $_POST['txtexpire'];
//Billing

$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef
 
);
if(!empty($data['voucher'])){
    $voucher = Voucher::Where("code",$data['voucher'])->Where('status','Chưa dùng')->first();
    $voucher->status = 'Đã sử dụng';
    $voucher->save();
    $inputData['voucher_code'] = $voucher->code;
    $inputData['vnp_Amount'] =  ($data['total'] - $data['sale'] - $voucher->value) * 100;
}

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}
if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
    $inputData['vnp_Bill_State'] = $vnp_Bill_State;
}

//var_dump($inputData);
ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}
$returnData = array('code' => '00'
    , 'message' => 'success' 
    , 'data' => $vnp_Url);
    if (isset($_POST['redirect'])) {
        header('Location: ' . $vnp_Url);
        die();
    } else {
        echo json_encode($returnData);
    }

        }//đóng thẻ thanh toán vnpay
    }
   

  public function checkout(Request $request) {  
    $vnpResponseCode = $request->query('vnp_ResponseCode');
    $vnpTxnRef = $request->query('vnp_TxnRef');
    $vnpAmount = $request->query('vnp_Amount');
    $voucher = $request->query('voucher_code');
    if($vnpResponseCode === '00'){

        $order = Order::with(['user','table'])->where('id',$vnpTxnRef)->Where('status','Chưa thanh toán')->first();
        $details = OrderDetails::with(['order','product'])->where('order_id',$vnpTxnRef)->where('status','Đã trả đồ')->get();
      $price = 0;
        foreach($details as $val){
            $val->status = 'Đã thanh toán';
            $price += $val->price;
            $val->save();
        }
        if(!empty($voucher)){
            $order->code = $voucher->id;
        }
        $order->payBy = Auth::user()->id;
        $order->payMethod = 'Vn Pay';
        $order->price = $price;
        $order->total = $vnpAmount/100;
        $order->discount = $price - $vnpAmount/100;
        $order->status = 'Đã thanh toán';
        $order->save();
        $table = Table::Where("id",$order->table->id)->first();
        $table->status = "";
        $table->save();
        $dataArray = [
            Auth::user()->id       
        ]; 
        Notification::create([
            'user_id' => Auth::user()->id,
            'content' =>  "Thanh toán đơn số ".$order->id,
            'read_by'  => $dataArray
        ]);
        broadcast(new payOrder($order,Auth::user()->id));
    //     $pdf = PDF::loadView('admin.Pay.exportPDF',[   'users' => Auth::user(),
    //     'title' => 'Chi tiết đơn hàng',
    //     'detailAll' => $details,
    //     'order' => $order,
    //     'total' => $order->price,
    //     'amout' => $order->total
    //   ])->setOptions(['defaultFont' => 'fontMetrics']);
    //     return $pdf->download('bill.pdf');
    return redirect()->route('revenue/list/')->with('success', 'Thanh toán thành công đơn '.$order->id);
    }else{
        return redirect()->route('bill/list/')->with('error', 'Thanh toán không thành công');
    }
  
  }

  public function indexRev(){
    
   $todayOrders = Order::with(['user','table','voucher'])->Where('status','Đã thanh toán')->orderBy('id','desc')->get();

    $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
    $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
    $dateStart  = date('Y-m-d');
    $dayend  = date('Y-m-d');
     return view('admin.Pay.revenue', [
         'users' => Auth::user(),
         'title' => 'Danh sách đơn hàng đã thanh toán',
         'Orders' => $todayOrders,
         'new' => $new,
         'daystart' => $dateStart,
        'dayend' => $dayend,
         'newAll' => $newAll
     ]);
  }

  public function showReDetail(int $id){
    $details = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Đã thanh toán')->orderBy('id','desc')->paginate(15);
    $details1 = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Đã thanh toán')->orderBy('id','Desc')->get();
    $total = 0;
    foreach($details1 as $val){
        $total += $val->price;
    }
    $order = Order::with(['user','table','voucher'])->where('id',$id)->first();
    $doDaTra = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Đã trả đồ')->count();
    $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
    $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
    return view('admin.Pay.reDetail', [
        'users' => Auth::user(),
        'title' => 'Chi tiết đơn hàng ',
        'details' => $details,
        'detailAll' => $details1,
        'order' => $order,
        'total' => $total,
        'doDaTra' => $doDaTra,
        'new' => $new,
        'newAll' => $newAll
    ]);
  }
  public function searchRe(Request $request){ 
    $dateStart = $request->daystart;
    $dateEnd =  $request->dayend;
    if($dateStart == $dateEnd){
        $donHangTheoNgay = Order::whereDate('created_at', '=', $dateStart)->get();
    }
    else if( $dateEnd < $dateStart ){
        return redirect()->route('revenue/list/')->with('error', 'Ngày bắt đầu phải bé hơn ngày kết thúc');
    }
    else{
        $donHangTheoNgay = Order::whereBetween('created_at', ["{$dateStart} 00:00:00", "{$dateEnd} 23:59:59"])->where('status','Đã thanh toán')->get();
    }
    
    
    $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
    $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
    return view('admin.Pay.revenue', [
        'users' => Auth::user(),
        'title' => 'Kết quả tìm kiếm đơn hàng đã thanh toán',
        'Orders' => $donHangTheoNgay,
        'new' => $new,
        'daystart' => $dateStart,
       'dayend' => $dateEnd,
        'newAll' => $newAll
    ]);
  }
}
