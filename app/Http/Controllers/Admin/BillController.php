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


use Illuminate\Support\Carbon;

class BillController extends Controller
{
    public function index(){
        $orderNew = Order::whereHas('OrderDetails', function ($query) {
            $query->where('status', 'Chưa trả đồ');
        })->orderBy('id','ASC')->paginate(15);
       
       $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
       $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.order.bill', [
            'users' => Auth::user(),
            'title' => 'Danh sách đơn hàng mới',
            'orderNew' => $orderNew,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function create(Request $request){
       
        $data = $request->all();
        $cart = Session::get('cart-'.$data['table_id']);
        $table_id = $data['table_id'];
        if(!empty($cart)){
       
       $orderList =  Order::all();
        $order;
       foreach($orderList as $val){
        if($val->table_id == $table_id && ($val->status === 'Chưa trả đồ' || $val->status === 'Chưa thanh toán' || $val->status === 'Chưa duyệt')){
            $order = $val;
            break;
        }
       }
        if(empty($order)){
                Order::create([
                    'user_id' => (int)$data['user_id'],
                    'table_id' => (int)$data['table_id'],
                    'mess' => (string)$data['mess_bill'],
                    'status' => 'Chưa trả đồ'             
                ]);
                $order = Order::with(['user','table'])->where('table_id',$data['table_id'])->where('status','Chưa trả đồ')->first();
                $table = Table::Where("id",$data['table_id'])->first();
                $table->status = "Đang có đơn";
                $table->save();
                foreach($cart as $key => $val){
                OrderDetails::create([
                        'name' =>(string)  $val['product_name'],
                        'product_id' => (int) $val['product_id'],
                        'order_id' =>  (int) $order->id,
                        'qty' => (int) $val['product_qty'],
                        'price' => (int) $val['product_price']* (int)$val['product_qty'],
                        'mess' =>  (string) $val['product_mess'],                   
                        'status' => 'Chưa trả đồ'
                    ]);
              
                }
               
                $user = Auth::user();
                $dataArray = [
                    $user->id          
                ];  
                Notification::create([
                    'user_id' => $user->id,
                    'content' =>  "Có đơn hàng mới ".$order->id.' bàn '.$order->table->name,
                    'read_by'  => $dataArray
                ]);
                Session::forget('cart-'.$data['table_id']);

                broadcast(new NewOrder($order,$user->id));       
                return response()->json([
                    'error' => $order           
                ]);
              
               
            }
            else{
               $order->status = 'Chưa trả đồ';
               $order->mess =(string) $data['mess_bill'];
               $order->updated_at =  date('Y-m-d H:i:s');
               $order->save();
               $order = Order::with(['user','table'])->where('table_id',$data['table_id'])->where('status','Chưa trả đồ')->first();
            
                foreach($cart as $key => $val){
              
              OrderDetails::create([
                        'name' =>(string)  $val['product_name'],
                        'product_id' => (int) $val['product_id'],
                        'order_id' =>  (int) $order->id,
                        'qty' => (int) $val['product_qty'],
                        'price' => (int) $val['product_price']* (int)$val['product_qty'],
                        'mess' =>  (string) $val['product_mess'],                   
                        'status' => 'Chưa trả đồ'
                    ]);
                   
                }
                $user = Auth::user();
                $dataArray = [
                    $user->id          
                ];  
                Notification::create([
                    'user_id' => $user->id,
                    'content' =>  "Có đơn hàng mới ".$order->id.' bàn '.$order->table->name,
                    'read_by'  => $dataArray
                ]);
                Session::forget('cart-'.$data['table_id']);
                broadcast(new NewOrder($order,$user->id));
                return response()->json([
                    'error' => false            
                ]);
               
               
            }
           
        }
        else { 
            return response()->json([
                'error' => true            
            ]);
        }
    }

    public function showDetails(int $id){
        $details = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Chưa trả đồ')->orderBy('id','ASC')->paginate(15);
        $check= OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Chưa trả đồ')->count();
        $order = Order::with(['user','table'])->where('id',$id)->first();
        $doDaTra = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Đã trả đồ')->count();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.order.detail', [
            'users' => Auth::user(),
            'title' => 'Chi tiết đơn hàng mới',
            'details' => $details,
            'order' => $order,
            'check' => $check,
            'doDaTra' => $doDaTra,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function finishDetails(Request $request){
        $listDetail = $request->id_Detail;
     
        $detail;
        foreach($listDetail as $val){
           $detail = OrderDetails::with(['order','product'])->where('id',$val)->where('status','Chưa trả đồ')->first();
            $detail->status = "Đã trả đồ";
            $detail->save();
        }
        $doChuaTra =  OrderDetails::where('order_id',$request->id)->where('status','Chưa trả đồ')->count();
      
        if($doChuaTra == 0){
            $order = Order::with(['user','table'])->where('id',$detail->order_id)->first();
            $order->status = "Chưa thanh toán";
            $order->save();
            $mess = [
                'status' => '0',
                'stt'=> $request->stt_Detail
            ];
            $user = Auth::user();
            $dataArray = [
                $user->id          
            ];  
            Notification::create([
                'user_id' => $user->id,
                'content' =>  "Trả toàn bộ đơn ".$order->id,
                'read_by'  => $dataArray
            ]);
            broadcast(new finishDetail($order,$mess,$user->id));
            return response()->json([
                'error' => false,
                'doChuaTra' => $doChuaTra           
            ]);
        }
        else {
            $order = Order::with(['user','table'])->where('id',$detail->order_id)->first();
            $mess = [
                'status' => '1',
                'stt'=> $request->stt_Detail
            ];
            $user = Auth::user();
            $dataArray = [
                $user->id          
            ];  
            Notification::create([
                'user_id' => $user->id,
                'content' =>  "Trả một phần đơn ".$order->id,
                'read_by'  => $dataArray
            ]);
            broadcast(new finishDetail($order,$mess,$user->id));
            return response()->json([
                'error' => false,
                'doChuaTra' => $doChuaTra             
            ]);
          
           
        }
    }
    public function updateDetails(Request $request){
        if(empty($request->qty) && !empty($request->mess)){
            $details = OrderDetails::with(['order','product'])->where('id',$request->id)->where('status','Chưa trả đồ')->first();
            $details->mess = $request->mess;
            $details->save();
            $order = Order::Where('id',$details->order_id)->first();
            $currentDateTimeFormatted = Carbon::now()->format('Y/m/d H:i:s');
            $order->updated_at = $details->$currentDateTimeFormatted ;
            $order->save();
            $user = Auth::user();
            $dataArray = [
                $user->id          
            ];  
            Notification::create([
                'user_id' => $user->id,
                'content' =>  "Cập nhật chi tiết đơn ".$order->id,
                'read_by'  => $dataArray
            ]);
            broadcast(new updateDetail($details,$user->id));
            return response()->json([
                'error' => false,
                'detail' => $details          
            ]);
        }
        else if(!empty($request->qty) && empty($request->mess)){
            $details = OrderDetails::with(['order','product'])->where('id',$request->id)->where('status','Chưa trả đồ')->first();
            $details->qty = $request->qty;
            $details->price =  $details->product->price * $request->qty;
            $details->save();
            $order = Order::Where('id',$details->order_id)->first();
            $order->updated_at = $details->updated_at;
            $order->save();
            $user = Auth::user();
            $dataArray = [
                $user->id          
            ];  
            Notification::create([
                'user_id' => $user->id,
                'content' =>  "Cập nhật chi tiết đơn ".$order->id,
                'read_by'  => $dataArray
            ]);
            broadcast(new updateDetail($details,$user->id));
            return response()->json([
                'error' => false,
                'detail' => $details                 
            ]);
        }
        else{
            return response()->json([
                'error' => true            
            ]);
        }
    }

    public function deleteDetails(Request $request){
        $details = OrderDetails::with(['order','product'])->where('id',$request->id)->where('status','Chưa trả đồ')->first(); 
     
        $array = [
            'id' => $details->id,
            'name' => $details->name,
            'product_id' => $details->product_id,
            'order_id' => $details->order_id,
            'qty' => $details->qty,
            'price' => $details->price,
            'mess' => $details->mess,
            'stt' => $request->stt,
            'status' => 'Chưa trả đồ'
        ];
        $details->status = 'Đã xóa';
        $details->save();
     
     
     
            $detailCheck = OrderDetails::where('order_id',$array['order_id'])->where('status','Chưa trả đồ')->count();
            $order = Order::Where('id',$array['order_id'])->first();
           
            if($detailCheck == 0){          
                $check = OrderDetails::with(['order','product'])->where('order_id',$array['order_id'])->where('status','Đã trả đồ')->count(); 
                if($check != 0){
                    $order->status = "Chưa thanh toán";
                    $order->save();
                    $array['status']= 'Chưa thanh toán';
                }
            }
            $currentDateTimeFormatted = Carbon::now()->format('Y/m/d H:i:s');
            $order->updated_at = $currentDateTimeFormatted ;
            $order->save(); 
            $user = Auth::user();
            $dataArray = [
                $user->id          
            ];  
            Notification::create([
                'user_id' => $user->id,
                'content' =>  "Xóa chi tiết đơn ".$order->id,
                'read_by'  => $dataArray
            ]);
            broadcast(new deleteDetail($array,$user->id));
            return response()->json([
                'error' => false,
                'detail' => $array
            ]);
     
    }
    public function deleteAllDetails(Request $request){
        $details = OrderDetails::with(['order','product'])->where('order_id',$request->id)->where('status','Chưa trả đồ')->get();
        $date;
        foreach($details as $key){
            $date = $key->updated_at;
        $key->status = 'Đã xóa';
        $key->save();
          
        }      
            $order = Order::Where('id',$request->id)->first();
            $check = OrderDetails::with(['order','product'])->where('order_id',$request->id)->where('status','Đã trả đồ')->count();
            $order->updated_at = $date;
            $order->save();
            if($check != 0){
                $order->status = "Chưa thanh toán";
                $order->save();
            }
            $user = Auth::user();
            $dataArray = [
                $user->id          
            ];  
            Notification::create([
                'user_id' => $user->id,
                'content' =>  "Xóa toàn bộ chi tiết đơn ".$order->id,
                'read_by'  => $dataArray
            ]);
            broadcast(new deleteAllDetail($order,$user->id));
           return response()->json([
               'error' => false,
               
           ]);
  
    }

    public function listBillCancle(){
        $orderCancle =  Order::with(['user','table'])->where('status','Đã hủy')->orderBy('id','DESC')->paginate(15);
       
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
         return view('admin.order.billCancle', [
             'users' => Auth::user(),
             'title' => 'Danh sách đơn hàng đã hủy',
             'orderCancle' => $orderCancle,
             'new' => $new,
             'newAll' => $newAll
         ]);
    }

    public function listDetailCancle(int $id){
        $details = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Đã hủy')->orderBy('id','ASC')->paginate(15);
       
        $order = Order::with(['user','table'])->where('id',$id)->first();
      
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.order.detailCancle', [
            'users' => Auth::user(),
            'title' => 'Chi tiết đơn hàng đã hủy',
            'details' => $details,
            'order' => $order,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }

    public function cancleOrder(Request $request){
       
        $details=   OrderDetails::with(['order','product'])->where('order_id',$request->id)->get();
        foreach($details as $val){
            $val->status = "Đã hủy";
            $val->save();
        }
    
  
     $o = Order::with(['user','table'])->Where('id',$request->id)->first();
     
    
    $table = Table::Where("id",$o->table->id)->first();
    $table->status = "";
    $table->save();
    $o->status = 'Đã hủy';
    $o->save();
   
      
            $user = Auth::user();
            $dataArray = [
                $user->id          
            ];  
            Notification::create([
                'user_id' => $user->id,
                'content' =>  "Hủy đơn ".$o->id." bàn ".$o->table->name,
                'read_by'  => $dataArray
            ]);
            broadcast(new cancleOrder($o,$user->id));
            return response()->json([
                'error' => false,
                
            ]);
      

    } 
    public function finishAllDetails(Request $request){
     $listDetail =  OrderDetails::with(['order','product'])->where('order_id',$request->id)->where('status','Chưa trả đồ')->get();
     foreach($listDetail as $val){
        $detail = OrderDetails::with(['order','product'])->where('id',$val->id)->where('status','Chưa trả đồ')->first();
         $detail->status = "Đã trả đồ";
         $detail->save();
     }
     $order = Order::with(['user','table'])->where('id',$request->id)->first();
     $order->status = "Chưa thanh toán";
     $order->save();
     $user = Auth::user();
     $dataArray = [
         $user->id          
     ];  
     Notification::create([
         'user_id' => $user->id,
         'content' =>  "Trả toàn bộ đơn ".$order->id." bàn ".$order->table->name,
         'read_by'  => $dataArray
     ]);
     broadcast(new finishAllDetail($order,$user->id));
     return response()->json([
         'error' => false
       
     ]);
    }  

   
}
