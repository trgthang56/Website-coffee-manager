
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
    <link rel="shortcut icon" href="/template/admin/dist/img/logocafe1.png" />
    <link rel="apple-touch-icon-precomposed" href="/template/admin/dist/img/logocafe1.png" />

    <title>Ưa thích</title>
    <style>
          .modal-fade {
        display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    overflow: auto; /* Thêm khả năng cuộn */
    z-index: 1;
}

.modal-content {
  position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    max-height: 80%; /* Đặt chiều dài tối đa */
    overflow-y: auto; /* Thêm khả năng cuộn */
    z-index: 1;
 
}
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}

        .cart-icon {
    position: relative;
    display: inline-block;
}

        #cart-count {
        
    position: absolute;
    top: -10%;
    right: -40%;
    background-color: red;
    color: white;
    border-radius:30%;
    padding: 5px 10px ;
    font-size: 0.5rem;
}


#callEmployeeButton {
    position: fixed;
    bottom: 80px; /* Khoảng cách từ dưới lên 20px */
    right: 20px; /* Khoảng cách từ phải sang trái 20px */
    padding: 10px 20px; /* Kích thước nút */
    background-color: #007bff; /* Màu nền */
    color: #fff; /* Màu chữ */
    border: none; /* Loại bỏ viền */
    border-radius: 5px; /* Bo tròn góc */
    cursor: pointer; /* Hiển thị con trỏ khi di chuột qua nút */
    transition: background-color 0.3s; /* Hiệu ứng transition cho hover */
    z-index: 998; /* Đảm bảo nút nằm trên tất cả các phần tử khác */
}



/* Responsive */
@media screen and (max-width: 768px) {
    #callEmployeeButton {
        padding: 8px 16px; /* Kích thước nút cho màn hình nhỏ hơn */
        font-size: 14px; /* Kích thước chữ cho màn hình nhỏ hơn */
    }
}

/* Hover */
#callEmployeeButton:hover {
    background-color: #0056b3; /* Màu nền khi hover */
}

    </style>
</head>

<body class="appFavorite">
    <div class="app profile pb-90">
        <div class="title-header-bar fixed-top bg-white">
            <a href="#" class="back-btn"><i class="icon-left"></i></a>
            <h1>Ưa thích</h1>
            <div class="cart-icon" >
             
                <a href="/customer/cart/show/{{$table_id}}/">  <span class="icon-buy" style="font-size: 2rem;color: #212529;"></span> </a>
                <span id="cart-count">{{$cart_count}}</span>
            </div>
        </div>
        <div class="tf-container pt-80">
            
            <div class="search-box">
                <span class="icon icon-search"></span>
                <form>
                    <input type="text" placeholder="Tìm đồ uống theo tên..." id="search_in" />
                  </form>
            </div>
            <div class="wrap-swiper">
                <div class="swiper cate-swiper">
                  <div class="swiper-wrapper pt-24 pb-30">
                      @foreach($child as $key => $val)
                    <div class="swiper-slide">
                      <form>
                    
                      <a class="box-categories " data-key="{{$val->name}}" onclick="CusSearchMenu(this)">
                      </form>
                        <span>{{$val->name}}</span>
                      </a>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              @if($loveProducts != 0)
            <ul>
               
                @foreach ($loveProducts as $product)
         
                <li class="tf-box-row mb-12">
                    <a href="" class="img-box">
                        <img src="/{{$product->thumb}}" alt="img">
                    </a>
                    <div class="content-box">
                        <h5><a href=""></a>{{$product->name}}</a> </h5>
                        <ul class="review">
                            <li>
                                <i class="icon-star"></i>
                                <span><?php  $decodedHtmlContent = html_entity_decode($product->content);
                                    echo $decodedHtmlContent; ?></span>&nbsp;
                            </li>
                        </ul>
                        <div class="box-price">
                            <ul class="price">
                                <li class="accent">{{$product->price}}đ</li>
                                {{-- <li class="del">$12.48</li> --}}
                            </ul>
                            <button type="button" class="btn-add" data-name="p-{{$product->id}}" onclick="openQuickView(this)">+</button>
                        </div>
                      
        
                    </div>
        
                </li>
              
               
            @endforeach
           
            </ul>
            @else
            <p> 
                Chưa có sản phẩm ưa thích nào
            </p>
            @endIF
            
        </div>
        

    </div>
    <a href="/customer/call/{{$table_id}}" id="callEmployeeButton" style="font-size: 16px">      
 
        Hỗ trợ&nbsp; <i class="fas fa-headset"></i>
        </a>
         
       
       
       @foreach($products as $product)
         <div class="products-preview"  data-target="p-{{$product->id}}">
     
                               
             <div class="preview" data-target="p-{{$product->id}}">
                <i class="fas fa-window-close" data-name="p-{{$product->id}}" onclick="closeQuickView(this)"></i>
                <img src="/{{$product->thumb}}" alt="">
                <h3>{{$product->name}}</h3>
                <p>{{$product->description}}</p>
               <form>
                 @csrf
               
                <div class="price" data-price="{{$product->price}}" id="price-{{$product->id}}">{{$product->price}}đ</div>
                
                <div class="counter">
                 <span class="down"  onClick='decreaseCount({{$product->id}}, this)'>-</span>
                 <input type="text" value="1" id="qty_{{$product->id}}">
                 <span class="up" onClick='increaseCount({{$product->id}}, this)'>+</span>
               </div>
              <div class="form-mess">
                 <input type="text" style="background-color: #fff;" class="input-mess" placeholder=" " name="mess" id="mess_{{$product->id}}">
                 <label for="mess_{{$product->id}}" class="form-label" >Ghi chú </label>
              </div>
     
                <div class="buttons">                              
                   <a  data-id="{{$product->id}}" data-name="p-{{$product->id}}" onclick="closeQuickView(this)" class="cart"> Thêm vào giỏ hàng</a>
                   {{-- <a  data-id="{{$product->id}}" data-name="p-{{$product->id}}"  class="cart-love"> <i class="far fa-heart"></i>&nbsp;Thêm vào đồ uống ưa thích</a> --}}
                </div>
                
             </form>
             </div>
             
         </div>
         @endforeach
    <div class="menubar-footer footer-fixed">
        <ul class="inner">
            <li >
                <a href="/customer/order/{{$table_id}}/"><span class="icon-home"></span> Trang chủ</a>
              </li>
              <li>
                <a href="/customer/discountIndex/{{$table_id}}"><span class="icon-discovery"></span> Khuyễn mãi</a>
              </li>
              <li>
                <a href="/customer/cart/show/{{$table_id}}/"><span class="icon-buy"></span> Giỏ hàng</a>
              </li>
              <li class="active">
                <a href="/customer/indexListLove/{{$table_id}}"><span class="icon-heart"></span> Ưa thích</a>
              </li>
              <li>
                <a href="/customer/profile/{{$table_id}}"><span class="icon-profile"></span> Cá nhân</a>
              </li>
        </ul>
    </div>
    <div id="myModal" class="modal-fade">
        <div class="modal-content">
            <span class="close" id="closeModalBtn">&times;</span>
            <div id="resultSearch"></div>
        </div>
    </div>
    

    <script type="text/javascript" src="/template/admin/order/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/jquery.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/carousel.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/sidebar.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/main.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/sweet-alert.js"></script>
    
    <script type="text/javascript">
        document.getElementById("search_in").addEventListener("keydown", function(event) {
        // Kiểm tra xem phím người dùng đã ấn có phải là phím Enter không
        if (event.key === "Enter") {
          e =  document.getElementById("search_in");
          event.preventDefault();
          CusSearch(e);
        }
    });
         document.addEventListener("DOMContentLoaded", function() {
     
        var closeModalBtn = document.getElementById('closeModalBtn');
        var modal = document.getElementById('myModal');
    
     
    
        closeModalBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });


    $(document).ready(function(){
          $('.cart').click(function(){
            var id = $(this).data('id');
            var table_id = {{$table_id}};
            var qty = $('#qty_' +id).val();
            var mess = $('#mess_' +id).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{URL::to('/customer/add/cart')}}',
                method: 'POST',
                data:{product_id:id,product_qty:qty,product_mess:mess,table_id:table_id,_token:_token,},
                success:function(data){
                    Swal.fire({
                    title: "Đã thêm giỏ hàng thành công",
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonText: "Đi tới giỏ hàng",
                    cancelButtonText: "Xem tiếp"
                    }).then((result) => {
                         /* Read more about isConfirmed, isDenied below */
                         count = parseInt(document.getElementById('cart-count').innerText);
                       document.getElementById('cart-count').innerText = count + parseInt(qty); 
                     if (result.isConfirmed) {
                        window.location.href = "{{url('customer/cart/show')}}"+'/'+{{$table_id}};
                        
                    }
                    
                        });
                    



                },
                error: function (error) {
                    alert("thêm giỏ hàng thất bại");
            }
            });
          });
         
        }); 
</script>
</body>

<!-- Mirrored from themesflat.co/html/coffeemonster/coffeeMonster-drink-app/payment-method.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Nov 2023 07:55:33 GMT -->
</html> 