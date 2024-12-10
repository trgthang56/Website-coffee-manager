
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesflat.co/html/coffeemonster/coffeeMonster-drink-app/payment-method.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Nov 2023 07:55:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="/template/admin/order/css/boostrap.min.css">
    <link rel="stylesheet" href="/template/admin/order/css/swiper-bundle.min.css" />
    <link rel="stylesheet"  type="text/css" href="/template/admin/order/css/sweet.css" />
    <link rel="stylesheet" type="text/css" href="/template/admin/order/css/styles.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="/template/admin/order/fonts/font-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="/template/admin/dist/img/logo.png" />
    <link rel="apple-touch-icon-precomposed" href="/template/admin/dist/img/logo.png" />

    <title>Giỏ hàng</title>
</head>

<body>
       <!-- preloade -->
       <div class="preload preload-container">
        <div class="preload-logo">
          <div class="spinner"></div>
        </div>
      </div>
    <!-- /preload -->

<div class="header">
    <div class="title-header-bar fixed-top bg-white">
        <a href="/customer/order/{{$table->id}}" ><i class="icon-left" style="font-size: 1.5rem"></i></a>
        <h1>Giỏ hàng bàn : <Strong>{{$table->name}}</Strong></h1>
        {{-- <span class="btn-sidebar">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 7H21" stroke="#033f38" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M3 12H21" stroke="#033f38" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M3 17H21" stroke="#033f38" stroke-width="1.5" stroke-linecap="round"></path>
            </svg>
        </span> --}}
    </div>
</div>
<div class="app pt-80 pb-70">
    @iF(!empty($cart))
   
    <div class="tf-container">
        <ul><?php $total = 0; ?>
            @foreach ($cart as $item)     
            <li class="tf-box-row style-2 qty mb-12">
                    <a class="img-box">
                        <img src="/{{$item['product_image']}}" alt="img">
                    </a>
                    <div class="content-box">
                        <h5><a > {{$item['product_name']}}</a></h5>
                        <ul class="review">
                            <li>                             
                                <span>{{$item['product_mess']}}</span>&nbsp;                               
                            </li>
                           
                        </ul>
                        <form >
                        <div class="total-qty">
                            <span class="price">{{$item['product_price']}}</span>
                          
                            <div class="sec-qty">
                               
                                <span class="btn-quantity minus-btn" data-session_id="{{$item['session_id']}}" data-name="min" onclick="ChangeQty(this)"><i class="icon-minus"></i></span>
                                
                                  
                                <input type="number" name="number" style="width: 2rem" id="qty-{{$item['session_id']}}" data-session_id="{{$item['session_id']}}"  value="{{$item['product_qty']}}" onchange="ChangeQty(this)">
                             
                                <span class="btn-quantity plus-btn" data-session_id="{{$item['session_id']}}" data-name="pluss"  onclick="ChangeQty(this)"><i class="icon-plus"></i></span>
                                                 </div>                        
                        </div>
                       
                            @csrf
                           
                      <i class="fas fa-trash-alt" style="font-size: 1.5rem;cursor: pointer;" data-session_id="{{$item['session_id']}}"  onclick="deleteProduct(this)"></i>
                    </form>
                    </div>
            </li>
            <?php $total += $item['product_qty'] * $item['product_price'];  ?>
            @endforeach
        </ul>
        <form>
            @csrf
            
            <input type="text" class="input-mess" id="mess_bill" placeholder="Ghi chú đơn hàng" >
             
         
        <div class="mt-30 mb-30">
            {{-- <p class="list-order line">
                Thành tiền: <span>$10.48</span>
            </p> --}}
            <p class="mt-15 list-order-total mb-26">
                Tổng tiền: <span><strong> <?php echo"$total";?></strong>&nbsp;đ</span>
            </p>
            <button onclick="order()" type="button">Tạo đơn hàng</button>              
        </div>
    </form>
    </div>
    @elseIf(empty($cart))
    <h1 style="text-align: center"> <i class="fas fa-weight-hanging"></i> &nbsp;Giỏ hàng trống quay lại trang chủ để chọn món</h1>
    @endIf
</div>

{{-- <div class="menubar-footer footer-fixed">
    <ul class="inner">
        <li><a href="/menu/order/{{$table->id}}/"><span class="icon-home"></span> Trang chủ</a></li>
        <li><a href="nearby.html"><span class="icon-discovery"></span> Nearby</a></li>
        <li  class="active"><a href="/cart/show/{{$table->id}}/"><span class="icon-buy"></span> Giỏ hàng</a></li>
        <li><a href="favorite.html"><span class="icon-heart"></span> Favorite</a></li>
        <li><a href="profile.html"><span class="icon-profile"></span> Cá nhân</a></li>
    </ul>
</div> --}}
    <script type="text/javascript" src="/template/admin/order/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/jquery.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/carousel.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/sidebar.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/main.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/sweet-alert.js"></script>
    
    <script type="text/javascript">
        
          function deleteProduct(event){
            var session_id = event.getAttribute('data-session_id');
            var _token = $('input[name="_token"]').val();
            var table_id = {{$table->id}};
             $.ajax({
              method : 'DELETE',
              datatype: 'JSON',
              data: {id:session_id,_token:_token,table_id:table_id,},
              url: '/delete/Cart',
              success: function(result){
                 if(result.error ==false){
                    location.reload();
                  
                  
                 }else{
                  alert('Xóa lỗi vui lòng thử lại');
                 }
              }
            });
          }
      
          function ChangeQty(event){    
       
            var session_id = event.getAttribute("data-session_id");
            var _token = $('input[name="_token"]').val();
            var table_id = {{$table->id}};
            var qty = document.getElementById("qty-"+session_id).value;
            if(event.getAttribute('data-name') === 'min'){
                qty--;
            }
            if(event.getAttribute('data-name') === 'pluss'){
                qty++;
            }
             $.ajax({
              method: 'POST',
              datatype: 'JSON',
              data: {id:session_id,table_id:table_id,qty:qty,_token:_token},
              url: '{{URL::to('/update/cart')}}',
              success: function(result){
                 if(result.error ==false){
                    location.reload();
                  
                  
                 }else{
                  alert('Lỗi vui lòng thử lại');
                 }
              },
          
            });
            } 
            
            function order(){
                var _token = $('input[name="_token"]').val();
                var table_id = {{$table->id}};
                var user_id = {{$users->id}};
                var mess_bill = document.getElementById("mess_bill").value;
                $.ajax({
              method: 'POST',
              data: {table_id:table_id,user_id:user_id,mess_bill:mess_bill,_token:_token},
              url: '{{URL::to('/order/create/bill')}}',
              success:function(data){
           
                    Swal.fire({

                    title: "Đã tạo đơn hàng thành công",
                    icon: "success",                         
                    confirmButtonText: "Đi tới trang chủ"                  
                    }).then((result) => {
                         /* Read more about isConfirmed, isDenied below */
                     if (result.isConfirmed) {
                        window.location.href = "{{url('/menu/order')}}"+'/'+{{$table->id}};

                    }
                    else{
                        location.reload();
                    }
                    
                        });
                    



                },
                error: function (error) {
                    alert("Tạo đơn thất bại");
            }
          
            });
            }

        

    </script>
</body>

<!-- Mirrored from themesflat.co/html/coffeemonster/coffeeMonster-drink-app/payment-method.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Nov 2023 07:55:33 GMT -->
</html>