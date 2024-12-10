<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesflat.co/html/coffeemonster/coffeeMonster-drink-app/profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Nov 2023 07:55:20 GMT -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="/template/admin/order/css/boostrap.min.css">
    <link rel="stylesheet" href="/template/admin/order/css/swiper-bundle.min.css" />
    <link rel="stylesheet"  type="text/css" href="/template/admin/order/css/sweet.css" />
    <link rel="stylesheet" type="text/css" href="/template/admin/order/css/styles.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="/template/admin/order/fonts/font-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="/template/admin/dist/img/logocafe1.png" />
    <link rel="apple-touch-icon-precomposed" href="/template/admin/dist/img/logocafe1.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cá nhân</title>
    <style>

#imagePreview {
  width: 200px;
  height: 200px;
  border: 2px solid #ccc;
  margin-top: 10px;
  display: none; /* Ẩn mặc định */
}

#imagePreview img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Đảm bảo ảnh không bị biến dạng */
}
.custom-file-upload {
  border: 1px solid #ccc;
  background-color: #f2f2f2;
  padding: 6px 12px;
  cursor: pointer;
  display: inline-block;
  border-radius: 4px;
}

.custom-file-upload:hover {
  background-color: #e0e0e0;
}
#form-account,#form-password{

    transition: opacity 0.3s ease-in-out;
}

    </style>

</head>

<body class="appProfile">
     <!-- preloade -->
     <div class="preload preload-container">
        <div class="preload-logo">
          <div class="spinner"></div>
        </div>
      </div>
    <!-- /preload -->
    <div class="app profile pb-90">
        <div class="title-header-bar fixed-top bg-white">
            
            <h1>Cá nhân</h1>

            <span class="btn-sidebar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 7H21" stroke="#033f38" stroke-width="1.5" stroke-linecap="round"></path>
                <path d="M3 12H21" stroke="#033f38" stroke-width="1.5" stroke-linecap="round"></path>
                <path d="M3 17H21" stroke="#033f38" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
            </span>
        </div>
        <div class="tf-container pt-80">
            
             <div class="box-profile">
                <div class="img">
                  
                    @if($user->image === null)
                    <img src="/template/admin/dist/img/avatar5.png" style="width: 100px;height: 100px;" alt="image">
                    {{-- <img class="img-circle img-bordered-sm" src="/template/admin/dist/img/customer.png"  alt="user image"> --}}
                  
                    @else <img class="img-circle img-bordered-sm" src="{{$user->image}}" style="width: 100px;height: 100px;" alt="user image"> @endIf
                </div>
                <div class="info">
                    <h3>{{$user->name}}</h3>
                    <strong > @if($user->role === 5) Khách hàng tiềm năng @else Khách hàng vip @endIF</strong><br><br>
                    <span>{{$user->email}}</span>
                   
                </div>
             </div> 
             <ul class="mt-30">
                <li>
                    <a  href="#" id="show-form-account" class="list-view line pb-16">
                        <i class="icon icon-profile"></i>
                        <span>Thông tin tài khoản</span>
                        <i class="icon-right"></i>
                    </a><br>
                
                    <form action="/customer/updateAcc/{{$table_id}}" method="POST" enctype="multipart/form-data" id="form-account" style="opacity: 0;display: none">
                        <div class="group-input mb-15">
                          
                            <i class="icon fas fa-file-signature"></i>
                            <input type="text" name="name" placeholder="Tên">
                        </div>
                        <label for="inputImage" class="custom-file-upload" style="font-size: 15px"> <i class="fas fa-images"></i>&nbsp; Chọn Ảnh Đại Diện</label>
                        <input type="file" id="inputImage" name="image" accept="image/*" style="display: none">

                        <!-- Hiển thị ảnh trước -->
                        <div id="imagePreview"></div>
                        
                        <button type="submit" style="margin-top: 2%">Cập nhật thông tin</button>
                        @csrf
                    </form>




                </li>
               

                {{-- <li>
                    <a href="payment-method.html" class="list-view line pt-16 pb-16">
                        <i class="icon icon-card-num"></i>
                        <span> Payment methods</span>
                        <i class="icon-right"></i>
                    </a>
                </li>
                <li>
                    <a href="location.html" class="list-view pt-16">
                        <i class="icon icon-location"></i>
                        <span> Delivery locations</span>
                        <i class="icon-right"></i>
                    </a>
                </li> --}}
             </ul> 
             <ul class="mt-50">
                <li>
                    <a href="#" id="show-form-password" class="list-view line pb-16">
                        <i class="icon icon-lock"></i>
                        <span>Đổi mật khẩu</span>
                        <i class="icon-right"></i>
                    </a><br>
                    <form action="/customer/updateAcc/{{$table_id}}" method="POST" id="form-password" style="opacity: 0;display: none;">
                        <!-- Định nghĩa các trường của form đổi mật khẩu ở đây -->
                        <div class="group-input mb-15 group-ip-password pd1">
                            <i class="icon icon-lock"></i>
                            <input class="password-field" type="password" name="password" placeholder="Mật khẩu cũ" required>
                            <div class="box-auth-show">
                                <span class="show-pass">
                                    <i class="icon-eye-hide"></i>
                                    <i class="icon-eye-show"></i>
                                </span>
                            </div>
                        </div>
                        <div class="group-input mb-15 group-ip-password pd1">
                            <i class="icon icon-lock"></i>
                            <input class="password-field" type="password" name="password1" placeholder="Mật khẩu" required>
                            <div class="box-auth-show">
                                <span class="show-pass">
                                    <i class="icon-eye-hide"></i>
                                    <i class="icon-eye-show"></i>
                                </span>
                            </div>
                        </div>
                        <div class="group-input mb-20 group-ip-password pd1">
                            <i class="icon icon-lock"></i>
                            <input class="password-field2" type="password" name="confirm" placeholder="Xác nhận mật khẩu" required>
                            <div class="box-auth-show">
                                <span class="show-pass2">
                                    <i class="icon-eye-hide"></i>
                                    <i class="icon-eye-show"></i>
                                </span>
                            </div>
                        </div>
                        @csrf
                        <button type="submit">Đổi Mật Khẩu</button>
                      </form>
                </li>
                {{-- <li>
                    <a href="#" class="list-view line pt-16 pb-16" data-bs-toggle="modal" data-bs-target="#modalRightFull">
                        <i class="icon icon-notification"></i>
                        <span> Notification</span>
                        <i class="icon-right"></i>
                    </a>
                </li>
                <li>
                    <a href="rate-coffee.html" class="list-view pt-16">
                        <i class="icon icon-star"></i>
                        <span> Rate</span>
                        <i class="icon-right"></i>
                    </a>
                </li> --}}
                
             </ul>
             <a href="/cus/logout/{{$table_id}}" class="list-view mt-50">
                <i class="icon icon-logout"></i>
                <span> Đăng xuất</span>
                <i class="icon-right"></i>
            </a>
        </div>
        

    </div>
  
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
              <li>
                <a href="/customer/indexListLove/{{$table_id}}"><span class="icon-heart"></span> Ưa thích</a>
              </li>
              <li class="active">
                <a href="/customer/profile/{{$table_id}}"><span class="icon-profile"></span> Cá nhân</a>
              </li>
        </ul>
    </div>


    <!-- modal  -->
    {{-- <div class="modal fade modalRight" id="modalRightFull">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="header">
                    <div class="tf-container">
                        <div class="title-header-bar pt-20 pb-20">
                            <a href="#" class="btn-close-modal" data-bs-dismiss="modal"><i class="icon-left"></i></a>
                            <h1>Notification</h1>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-body pb-30">
                    <div class="tf-container">
                       <h5>Today</h5>
                       <ul class="mt-12">
                            <li>
                                <a href="#" class="list-noti line pb-22">
                                    <div class="box-img">
                                        <img src="images/food/img-1.jpg" alt="img">
                                    </div>
                                    <div class="content">
                                        <h4>Your order has been confirmed</h4>
                                        <p>CoffeeMonster has confirmed your order, we will deliver to your address in 30 minutes</p>
                                        <span>2 min ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="list-noti pt-22">
                                    <div class="box-img">
                                        <img src="images/food/img-2.jpg" alt="img">
                                    </div>
                                    <div class="content">
                                        <h4>CoffeeMonster sale 50% today</h4>
                                        <p>Enter discount code coffeemonster50% for 50% off for order $20</p>
                                        <span>6 hour ago</span>
                                    </div>
                                </a>
                            </li>
                       </ul>
                       <h5 class="mt-40">Yesterday</h5>
                       <ul class="mt-12">
                            <li>
                                <a href="#" class="list-noti line pb-22">
                                    <div class="box-img">
                                        <img src="images/food/img-3.jpg" alt="img">
                                    </div>
                                    <div class="content">
                                        <h4>By 1 get 1</h4>
                                        <p>By1 get 1 free for small sizes until sep 30, 2021 when you order via CoffMonster</p>
                                        <span>2 min ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="list-noti line pt-22 pb-22">
                                    <div class="box-img">
                                        <img src="images/food/img-4.jpg" alt="img">
                                    </div>
                                    <div class="content">
                                        <h4>CoffeeMonster sale 50% today</h4>
                                        <p>Enter discount code coffeemonster50% for 50% off for order $20</p>
                                        <span>6 hour ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="list-noti pt-22 ">
                                    <div class="box-img">
                                        <img src="images/food/img-5.jpg" alt="img">
                                    </div>
                                    <div class="content">
                                        <h4>CoffeeMonster sale 50% today</h4>
                                        <p>Enter discount code coffeemonster50% for 50% off for order $20</p>
                                        <span>6 hour ago</span>
                                    </div>
                                </a>
                            </li>
                       </ul>
                    </div>
                </div>
               
            </div>
        </div>
    </div> --}}
  

       
    <script type="text/javascript" src="/template/admin/order/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/jquery.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/carousel.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/sidebar.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/main.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/sweet-alert.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif
@if(Session::has('error'))
<script>toastr.error("{{Session::get('error')}}");</script>
@endIF
    <script> 
    document.getElementById("inputImage").addEventListener("change", function(event) {
  var file = event.target.files[0]; // Lấy file ảnh từ input
  var reader = new FileReader(); // Tạo một FileReader object

  // Xử lý khi FileReader hoàn thành đọc file
  reader.onload = function(e) {
    var imagePreview = document.getElementById("imagePreview");
    imagePreview.innerHTML = ''; // Xóa bỏ ảnh trước (nếu có)
    var img = document.createElement("img");
    img.src = e.target.result; // Thiết lập src của ảnh là dữ liệu ảnh được đọc từ file
    imagePreview.appendChild(img); // Thêm ảnh vào div hiển thị ảnh trước
    imagePreview.style.display = "block"; // Hiển thị div hiển thị ảnh trước
  };

  // Đọc file ảnh dưới dạng data URL
  reader.readAsDataURL(file);
});
document.getElementById("show-form-account").addEventListener("click", function(event) {
    if(document.getElementById("form-account").style.display === 'none'){

        document.getElementById("form-account").style.display = "block";
        setTimeout(function() {
            document.getElementById("form-account").style.opacity = '1';
        }, 200); // 0.5 giây sau khi opacity đã thay đổi
     
    }else{
        document.getElementById("form-account").style.opacity = '0';
        setTimeout(function() {
            document.getElementById("form-account").style.display = 'none'; // Ẩn nội dung sau khi opacity đã trở về 0
        }, 200); // 0.5 giây sau khi opacity đã thay đổi
    }
  
});
document.getElementById("show-form-password").addEventListener("click", function(event) {
    if(document.getElementById("form-password").style.display === 'none'){

document.getElementById("form-password").style.display = "block";
setTimeout(function() {
    document.getElementById("form-password").style.opacity = '1';
}, 200); // 0.5 giây sau khi opacity đã thay đổi

}else{
document.getElementById("form-password").style.opacity = '0';
setTimeout(function() {
    document.getElementById("form-password").style.display = 'none'; // Ẩn nội dung sau khi opacity đã trở về 0
}, 200); // 0.5 giây sau khi opacity đã thay đổi
}
});
    </script>
</body>

<!-- Mirrored from themesflat.co/html/coffeemonster/coffeeMonster-drink-app/profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Nov 2023 07:55:26 GMT -->
</html>