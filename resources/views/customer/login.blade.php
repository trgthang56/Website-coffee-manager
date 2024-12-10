<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesflat.co/html/coffeemonster/coffeeMonster-drink-app/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Nov 2023 07:55:36 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/template/admin/order/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="/template/admin/order/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/template/admin/order/css/boostrap.min.css">
    
    <link rel="stylesheet"type="text/css" href="/template/admin/order/css/styles.css"/>
    <!-- Icons -->
    <link rel="stylesheet" href="/template/admin/order/fonts/font-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="/template/admin/dist/img/logocafe1.png" />
    <link rel="apple-touch-icon-precomposed" href="/template/admin/dist/img/logocafe1.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Đăng nhập</title>
</head>

<body>
     <!-- preloade -->
     <div class="preload preload-container">
        <div class="preload-logo">
          <div class="spinner"></div>
        </div>
      </div>
    <!-- /preload -->
    <div class="account-area" style="background-image: url('/template/admin/order/images/background/bgr2.jpg')">
        <div class="tf-container">
            <div class="logo-app pt-20">
                <a href="/customer/order/{{$table_id}}">
                <img src="/template/admin/dist/img/logocafe1.png" >
            </a>
            </div>
           

            <div class="acount-box" >
               
                <ul class="nav nav-tabs mb-23" id="account-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="auth-tab" data-bs-toggle="tab" data-bs-target="#signin"  role="tab" aria-controls="signin" aria-selected="true">Đăng nhập</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#signup" role="tab" aria-controls="signup" aria-selected="false">Đăng ký</a>
                    </li>
                 
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="signin" role="tabpanel">
                        <form action="/customer/login/store/{{$table_id}}" method="POST" class="tf-form">
                            <div class="group-input mb-15">
                                <i class="icon fas fa-envelope"></i>
                                <input type="text" name="email" placeholder="Email">
                            </div>
                            <div class="group-input mb-15 group-ip-password">
                                <i class="icon icon-lock"></i>
                                <input required class="password-field" type="password" name="password" placeholder="Mật khẩu">
                                <div class="box-auth-show">
                                    <span class="show-pass">
                                        <i class="icon-eye-hide"></i>
                                        <i class="icon-eye-show"></i>
                                    </span>
                                </div>
                            </div>
                            <a href="reset-pass.html" class="forgot-link mb-15">Quên mật khẩu</a>
                            <button type="submit">Đăng nhập</button>
                            @csrf
                        </form>
                        {{-- <p class="other mb-20 mt-20">Đăng nhập phương thức khác</p>    
                        <a href="index.html" class="tf-btn large social mb-15">
                            <img src="/template/admin/order/images/socials/fb.jpg" alt="images">
                            Đăng nhập với facebook
                        </a>
                        <a href="index.html" class="tf-btn large social">
                            <img src="/template/admin/order/images/socials/google.jpg" alt="images">
                            Đăng nhập với google
                        </a> --}}
                           
                    </div>
                    <div class="tab-pane fade" id="signup" role="tabpanel">
                        <form action="/cus/store/{{$table_id}}" class="tf-form" method="POST">
                            <div class="group-input mb-15">
                              
                                <i class="icon fas fa-id-card"></i>
                             
                   
								<input type="text" class="form-control" name="name" placeholder="Họ tên">
							</div>
                            <div class="group-input mb-15">
                              
                                <i class="icon fas fa-envelope"></i>
                             
                   
								<input type="text" class="form-control" name="email" placeholder="Email">
							</div>
                            <div class="group-input mb-15 group-ip-password pd1">
                                <i class="icon icon-lock"></i>
                                <input class="password-field" type="password" name="password" placeholder="Mật khẩu">
                                <div class="box-auth-show">
                                    <span class="show-pass">
                                        <i class="icon-eye-hide"></i>
                                        <i class="icon-eye-show"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="group-input mb-20 group-ip-password pd1">
                                <i class="icon icon-lock"></i>
                                <input class="password-field2" type="password" name="confirm" placeholder="Xác nhận mật khẩu">
                                <div class="box-auth-show">
                                    <span class="show-pass2">
                                        <i class="icon-eye-hide"></i>
                                        <i class="icon-eye-show"></i>
                                    </span>
                                </div>
                            </div>
                            <button type="submit">Đăng ký</button>
                            @csrf
                        </form>
                        {{-- <p class="other mb-20 mt-20">Đăng nhập phương thức khác</p>  
                        <div class="group-btn-social">
                            <a href="index.html" class="tf-btn large social">
                                <img src="/template/admin/order/images/socials/fb.jpg" alt="images">
                                Facebook
                            </a>
                            <a href="index.html" class="tf-btn large social">
                                <img src="/template/admin/order/images/socials/google.jpg" alt="images">
                                 Google
                            </a>  
                        </div>   --}}
                             
                        
                     
                           
                    </div>
    
                </div>
                
                
                
            </div>
              
        </div>
        

    </div>
    <script type="text/javascript" src="/template/admin/order/js/jquery.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="/template/admin/order/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif
@if(Session::has('error'))
<script>toastr.error("{{Session::get('error')}}");</script>
@endIF
</body>

<!-- Mirrored from themesflat.co/html/coffeemonster/coffeeMonster-drink-app/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Nov 2023 07:55:39 GMT -->
</html>