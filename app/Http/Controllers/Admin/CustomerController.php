<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Product;
use App\Http\Services\Menu\MenuService;
use App\Models\Notification;
use App\Events\cusCall;
use Illuminate\Support\Facades\Event;
use App\Models\Voucher;
use Illuminate\Support\Facades\Broadcast;

class CustomerController extends Controller
{
    public function __construct(MenuService $menuService){
        $this->menuService = $menuService;
    }

    public function showMenu(int $id){
        $menus = Menu::all();
        $tabale = Table::Where('id',$id)->first();
        $menuChild= array();
        foreach($menus as $item){
            if($item->parent_id != 0){                      
                        array_push( $menuChild,  $item );                                                      
            }
         }
        //  dd(Session::get('cart-'.$id));
        $cart = Session::get('cusCart-'.$id);
        $count = 0;
        if(Session::has('cusCart-'.$id)){
            foreach($cart as $key => $val){
                $count += $val['product_qty'];
            }
        }
        $topProducts = Product::orderBy('sale_count', 'desc')->take(10)->get();
        return view('customer.order.menu',[
            'table' => $tabale,
            'menus' => $this->menuService->getParent(),
            'child' => $menuChild,
            'products' => Product::all(),
            'cart_count' => $count,
            'topProducts' => $topProducts

        ]);
    }
    public function create(Request $request){
        session_start();
         $data = $request->all();  
         $id = $data['table_id'];
         $product = Product::Where('id',$data['product_id'])->first();
         $session_id = substr(md5(microtime()),rand(0,26),5);
         // session_destroy();
      
         if(Session::has('cusCart-'.$id)){
             $cart = Session::get('cusCart-'.$id);
             $is_avaiable = 0;
             foreach($cart as $key => $val){
                 if($val['product_id']==$data['product_id'] && strcasecmp($val['product_mess'],$data['product_mess']) == 0){
                     $cart[$key] = array(
                     'session_id' => $session_id,
                     'product_name' => $product->name,
                     'product_id' => $product->id,
                     'product_image' => $product->thumb,
                     'product_qty' => $data['product_qty']+$val['product_qty'],
                     'product_mess' => $data['product_mess'],
                     'product_price' => $product->price,
                         );
                     Session::put('cusCart-'.$id,$cart);
                     $is_avaiable++;
                     break;
                 }
             }
             if($is_avaiable == 0){
                 $cart[] = array(
                     'session_id' => $session_id,
                     'product_name' => $product->name,
                     'product_id' => $product->id,
                     'product_image' => $product->thumb,
                     'product_qty' => $data['product_qty'],
                     'product_mess' => $data['product_mess'],
                     'product_price' => $product->price,
                 );
                 Session::put('cusCart-'.$id,$cart);
             }
         }else{
             $cart[] = array(
                 'session_id' => $session_id,
                 'product_name' => $product->name,
                 'product_id' => $product->id,
                 'product_image' => $product->thumb,
                 'product_qty' => $data['product_qty'],
                 'product_mess' => $data['product_mess'],
                 'product_price' => $product->price,
 
             );
             Session::put('cusCart-'.$id,$cart);
         }
         Session::save();
    
      
         return response()->json([
            'message' => 'Đã thêm giỏ hàng thành công',        
         ]);
     }
 
     public function deleteProduct(Request $request){
         $data = $request->all();
         $cart = Session::get('cusCart-'.$data['table_id']);
         if($cart==true){
             foreach($cart as $key => $val){
                 if($val['session_id'] === $data['id']){
                     unset($cart[$key]);
                     break;
                 }
             }
             Session::put('cusCart-'.$data['table_id'],$cart);
             return response()->json([
                 'error' => false            
             ]);
         }
      else{
         return response()->json([
             'error' => true            
         ]);
      }
     }
 
     public function update(Request $request){
         $data = $request->all();
         // dd($data);
        
         $cart = Session::get('cusCart-'.$data['table_id']);
         if($cart==true){
             if($data['qty'] < 1){
                 foreach($cart as $key => $val){
                     if($val['session_id'] === $data['id']){
                         unset($cart[$key]);
                         break;
                     }
                 }
             }
             else{
                 foreach($cart as $key => $val){
                 if($val['session_id'] === $data['id']){
                     $cart[$key]['product_qty'] = $data['qty'];
                         break;
                 }
             }
         }
             
             Session::put('cusCart-'.$data['table_id'],$cart);       
             return response()->json([
                 'error' => false            
             ]);
         }
      else{
         return response()->json([
             'error' => true            
         ]);
      }
     }
 
    public function search(Request $request){
        $keyWord = $request->keyWord;
        $result =  Product::Where('name','like','%'.$keyWord.'%')->get();
        
        return response()->json([
            'error' => false ,
            'result' => $result,
            'keyWord' => $keyWord           
        ]);
        
    }
    public function searchMenu(Request $request){
        $keyWord = $request->keyWord;
        $menu = Menu::Where('name',$keyWord)->first();
        $result =  Product::Where('menu_id',$menu->id)->get();
        
        return response()->json([
            'error' => false ,
            'result' => $result,
            'keyWord' => $keyWord               
        ]);
        
    }
    public function showCart(int $id){
        $menus = Menu::all();
        $tabale = Table::Where('id',$id)->first();   
        //  dd(Session::get('cart-'.$id));
        $cart = Session::get('cusCart-'.$id);
        return view('customer.order.showCart',[
            'table' => $tabale,               
            'products' => Product::all(),
            'cart' => $cart
        ]);
    }

    public function showProfile(int $id){
        return view('customer.order.cusprofile',[
            'user' => Auth::user(),
            'table_id' => $id
        ]);
    }
    public function loginIndex(int $id){
  
        return view('customer.login',[
            'table_id' => $id
        ]);
    }

    public function call(int $id){
        $table = Table::where('id',$id)->first();
        $dataArray = [0];  
        Notification::create([
            'user_id' => '0',
            'content' =>  "Khách gọi nhân viên bàn ".$table->name,
            'read_by'  => $dataArray
        ]);
        broadcast(new cusCall($table));
        return redirect()->back()->with('success','Đã gọi nhân viên thành công');
    }
    public function indexListLove(int $id){
        $menus = Menu::Where('parent_id','!=','0')->get();
        $tabale = Table::Where('id',$id)->first();
        $user = Auth::user();
        $listLove= array();
        if(!empty($user->loveList)){
            $allP = Product::all();
           
            foreach($allP as $val){
                if(in_array($val->id,$user->loveList)){
                    array_push($listLove, $val);
                }
            }
        }else{
            $listLove = 0;
        }
        $cart = Session::get('cusCart-'.$id);
        $count = 0;
        if(Session::has('cusCart-'.$id)){
            foreach($cart as $key => $val){
                $count += $val['product_qty'];
            }
        }
        return view('customer.order.loveList',[
            'table_id' => $id,
            'child' => $menus,
            'products' => Product::all(),
            'loveProducts' => $listLove,
            'cart_count' => $count,
        ]);
    }

    public function discountIndex(int $id){
 
        $tabale = Table::Where('id',$id)->first();
        $user = Auth::user();
        $cart = Session::get('cusCart-'.$id);
        $count = 0;
        if(Session::has('cusCart-'.$id)){
            foreach($cart as $key => $val){
                $count += $val['product_qty'];
            }
        }
        $voucher = Voucher::Where('user_id',$user->id)->Where('status','Chưa dùng')->get();
        $voucherCount = Voucher::Where('user_id',$user->id)->Where('status','Chưa dùng')->count();
        return view('customer.order.discount',[
            'table_id' => $id,
            'products' => Product::all(),
            'vouchers' => $voucher,
            'voucherCount' => $voucherCount,
            'cart_count' => $count,
        ]);
    }
}
