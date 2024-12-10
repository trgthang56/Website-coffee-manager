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



class OrderController extends Controller
{
    public function __construct(MenuService $menuService){
        $this->menuService = $menuService;
    }
 
    public function index(){     
            $listTable1 = Table::Where('location','Trong nhà')->get();            
            $listTable2 = Table::Where('location','Sân trước')->get();             
            $listTable3 = Table::Where('location','vườn sỏi')->get();
            $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
            $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.order.table',[
            'title' => 'Danh sách bàn',
            'users' => Auth::user(),
            'listTable1' => $listTable1,
            'listTable2' => $listTable2,
            'listTable3' => $listTable3,
            'new' => $new,
            'newAll' => $newAll
        ]);
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
        $cart = Session::get('cart-'.$id);
        $count = 0;
        if(Session::has('cart-'.$id)){
            foreach($cart as $key => $val){
                $count += $val['product_qty'];
            }
        }
        $topProducts = Product::orderBy('sale_count', 'desc')->take(10)->get();
        return view('admin.order.menu',[
            'table' => $tabale,
            'users' => Auth::user(),
            'menus' => $this->menuService->getParent(),
            'child' => $menuChild,
            'products' => Product::all(),
            'cart_count' => $count,
            'topProducts' => $topProducts

        ]);
    }
    
    public function showCart(int $id){
        $menus = Menu::all();
        $tabale = Table::Where('id',$id)->first();   
        //  dd(Session::get('cart-'.$id));
        $cart = Session::get('cart-'.$id);
        return view('admin.order.showCart',[
            'table' => $tabale,
            'users' => Auth::user(),                   
            'products' => Product::all(),
            'cart' => $cart
        ]);
    }
    public function create(Request $request){
       session_start();
        $data = $request->all();  
        $id = $data['table_id'];
        $product = Product::Where('id',$data['product_id'])->first();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        // session_destroy();
     
        if(Session::has('cart-'.$id)){
            $cart = Session::get('cart-'.$id);
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
                    Session::put('cart-'.$id,$cart);
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
                Session::put('cart-'.$id,$cart);
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
            Session::put('cart-'.$id,$cart);
        }
        Session::save();
   
     
        return response()->json([
           'message' => 'Đã thêm giỏ hàng thành công',        
        ]);
    }

    public function deleteProduct(Request $request){
        $data = $request->all();
        $cart = Session::get('cart-'.$data['table_id']);
        if($cart==true){
            foreach($cart as $key => $val){
                if($val['session_id'] === $data['id']){
                    unset($cart[$key]);
                    break;
                }
            }
            Session::put('cart-'.$data['table_id'],$cart);
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
       
        $cart = Session::get('cart-'.$data['table_id']);
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
            
            Session::put('cart-'.$data['table_id'],$cart);       
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
            'result' => $result           
        ]);
        
    }
}
