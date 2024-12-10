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
use App\Events\cusOrder;
use App\Events\confirmAllDetail;
use App\Events\finishAllDetail;
use Illuminate\Support\Carbon;

class CusBillController extends Controller
{
    public function index(){
        $orderNew = Order::whereHas('OrderDetails', function ($query) {
            $query->where('status', 'Chưa duyệt');
        })->orderBy('id','ASC')->paginate(15);
       
       $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
       $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.order.cusBill', [
            'users' => Auth::user(),
            'title' => 'Danh sách đơn hàng khách order',
            'orderNew' => $orderNew,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }

    public function cusCreate(Request $request){
       
        $data = $request->all();
        $cart = Session::get('cusCart-'.$data['table_id']);
        $table_id = $data['table_id'];
        if(!empty($cart)){
       
       $orderList =  Order::all();
        $order;
       foreach($orderList as $val){
        if($val->table_id == $table_id && ($val->status === 'Chưa trả đồ' || $val->status === 'Chưa thanh toán') || $val->status === 'Chưa duyệt'){
            $order = $val; 
            break;
        }
       }
        if(empty($order)){
                Order::create([
                    'user_id' => '0',
                    'table_id' => (int)$data['table_id'],
                    'mess' => (string)$data['mess_bill'],
                    'status' => 'Chưa duyệt'             
                ]);
                $order = Order::with(['user','table'])->where('table_id',$data['table_id'])->where('status','Chưa duyệt')->first();
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
                        'status' => 'Chưa duyệt'
                    ]);
              
                }
                $dataArray = [0];  
                Notification::create([
                    'user_id' => '0',
                    'content' =>  "Khách order đơn tại bàn ".$order->table->name,
                    'read_by'  => $dataArray
                ]);
                Session::forget('cusCart-'.$data['table_id']);

                broadcast(new cusOrder($order));       
                return response()->json([
                    'error' => $order           
                ]);
              
               
            }
            else{
               $order->status = 'Chưa duyệt';
               $order->mess =(string) $data['mess_bill'];
               $order->updated_at =  date('Y-m-d H:i:s');
               $order->save();
               $order = Order::with(['user','table'])->where('table_id',$data['table_id'])->where('status','Chưa duyệt')->first();
            
                foreach($cart as $key => $val){
              
              OrderDetails::create([
                        'name' =>(string)  $val['product_name'],
                        'product_id' => (int) $val['product_id'],
                        'order_id' =>  (int) $order->id,
                        'qty' => (int) $val['product_qty'],
                        'price' => (int) $val['product_price']* (int)$val['product_qty'],
                        'mess' =>  (string) $val['product_mess'],                   
                        'status' => 'Chưa duyệt'
                    ]);
                   
                }

                $dataArray = [0];  
                Notification::create([
                    'user_id' => '0',
                    'content' =>  "Khách order đơn tại bàn ".$order->table->name,
                    'read_by'  => $dataArray
                ]);
                Session::forget('cusCart-'.$data['table_id']);
                broadcast(new cusOrder($order));
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
        $details = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Chưa duyệt')->orderBy('id','ASC')->paginate(15);
        $check= OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Chưa duyệt')->count();
        $order = Order::with(['user','table'])->where('id',$id)->first();
        $doDaTra = OrderDetails::with(['order','product'])->where('order_id',$id)->where('status','Chưa trả đồ')->count();
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.order.cusDetail', [
            'users' => Auth::user(),
            'title' => 'Chi tiết đơn hàng khách order',
            'details' => $details,
            'order' => $order,
            'check' => $check,
            'doDaTra' => $doDaTra,
            'new' => $new,
            'newAll' => $newAll
        ]);
    }
    public function confirmAllDetails(Request $request){
        $listDetail =  OrderDetails::with(['order','product'])->where('order_id',$request->id)->where('status','Chưa duyệt')->get();
        foreach($listDetail as $val){
            $val->status = "Chưa trả đồ";
            $val->save();
        }
        $user = Auth::user();
        $order = Order::with('table')->where('id',$request->id)->first();
        $order->user_id = $user->id;
        $order->status = "Chưa trả đồ";
        $order->save();
      
        $dataArray = [
            $user->id          
        ];  
        Notification::create([
            'user_id' => $user->id,
            'content' =>  "Duyệt toàn bộ đơn ".$order->id,
            'read_by'  => $dataArray
        ]);
        broadcast(new confirmAllDetail($order,$user->id));
        return response()->json([
            'error' => false
          
        ]);
       }  


       public function updateCusDetails(Request $request){
        if(empty($request->qty) && !empty($request->mess)){
            $details = OrderDetails::with(['order','product'])->where('id',$request->id)->where('status','Chưa duyệt')->first();
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
            $details = OrderDetails::with(['order','product'])->where('id',$request->id)->where('status','Chưa duyệt')->first();
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


    public function deleteCusDetails(Request $request){
        $details = OrderDetails::with(['order','product'])->where('id',$request->id)->where('status','Chưa duyệt')->first(); 
     
        $array = [
            'id' => $details->id,
            'name' => $details->name,
            'product_id' => $details->product_id,
            'order_id' => $details->order_id,
            'qty' => $details->qty,
            'price' => $details->price,
            'mess' => $details->mess,
            'stt' => $request->stt,
            'status' => 'Chưa duyệt'
        ];
        $details->status = 'Đã xóa';
        $details->save();
     
     
     
            $detailCheck = OrderDetails::where('order_id',$array['order_id'])->where('status','Chưa duyệt')->count();
            $order = Order::Where('id',$array['order_id'])->first();
           
            if($detailCheck == 0){
                $check =  OrderDetails::with(['order','product'])->where('order_id',$array['order_id'])->where('status','Chưa trả đồ')->count();     
                $check1 = OrderDetails::with(['order','product'])->where('order_id',$array['order_id'])->where('status','Đã trả đồ')->count(); 
                if($check != 0){
                    $order->status = "Chưa trả đồ";
                    $order->save();
                    $array['status']= "Chưa trả đồ";
                }
               else if($check1 != 0){
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

    public function deleteAllCusDetails(Request $request){
        $details = OrderDetails::with(['order','product'])->where('order_id',$request->id)->where('status','Chưa duyệt')->get();
        foreach($details as $key){
        $key->status = 'Đã xóa';
        $key->save();
          
        }      
            $order = Order::Where('id',$request->id)->first();
            $currentDateTimeFormatted = Carbon::now()->format('Y/m/d H:i:s');
            $order->updated_at = $currentDateTimeFormatted ;
            $order->save();
            $check =  OrderDetails::with(['order','product'])->where('order_id',$request->id)->where('status','Chưa trả đồ')->count();     
            $check1 = OrderDetails::with(['order','product'])->where('order_id',$request->id)->where('status','Đã trả đồ')->count(); 
            if($check != 0){
                $order->status = "Chưa trả đồ";
                $order->save();
                $array['status']= "Chưa trả đồ";
            }
           else if($check1 != 0){
                $order->status = "Chưa thanh toán";
                $order->save();
                $array['status']= 'Chưa thanh toán';
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
}
