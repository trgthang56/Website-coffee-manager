<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from themesflat.co/html/coffeemonster/coffeeMonster-drink-app/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Nov 2023 07:54:37 GMT -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="/template/admin/order/css/boostrap.min.css">
    <link rel="stylesheet" href="/template/admin/order/css/swiper-bundle.min.css" />
    <link rel="stylesheet"  type="text/css" href="/template/admin/order/css/sweet.css" />
    <link rel="stylesheet" type="text/css" href="/template/admin/order/css/styles.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="/template/admin/order/fonts/font-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="/template/admin/dist/img/logocafe1.png" />
    <link rel="apple-touch-icon-precomposed" href="/template/admin/dist/img/logocafe1.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gọi món</title>
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

.cart-love:hover{
  transition: background-color 0.3s;
  background-color: pink;
}
    </style>
  </head>

  <body class="appHome">
    <div class="preload preload-container">
        <div class="preload-logo">
          <div class="spinner"></div>
        </div>
      </div>

    <div class="app home-1">
        <div class="inner-headerbar fixed-top  st1" style="background: #033f38 !important ">
            <div class="header-location">
                <p>Vị trí: <strong>{{$table->location}}</strong></p>
                <span class="location">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="17"
                    viewBox="0 0 16 17"
                    fill="none"
                  >
                    <path
                      d="M11.7714 11.6045L8.94269 14.4331C8.81898 14.557 8.67209 14.6552 8.5104 14.7222C8.3487 14.7892 8.17539 14.8237 8.00036 14.8237C7.82532 14.8237 7.65201 14.7892 7.49032 14.7222C7.32862 14.6552 7.18173 14.557 7.05802 14.4331L4.22869 11.6045C3.48284 10.8586 2.97491 9.90827 2.76915 8.87371C2.56338 7.83916 2.66902 6.76681 3.07269 5.79229C3.47637 4.81777 4.15995 3.98483 5.03701 3.39881C5.91407 2.81279 6.9452 2.5 8.00002 2.5C9.05485 2.5 10.086 2.81279 10.963 3.39881C11.8401 3.98483 12.5237 4.81777 12.9274 5.79229C13.331 6.76681 13.4367 7.83916 13.2309 8.87371C13.0251 9.90827 12.5172 10.8586 11.7714 11.6045V11.6045Z"
                      stroke="white"
                      stroke-width="1.33333"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M10 7.8335C10 8.36393 9.78929 8.87264 9.41421 9.24771C9.03914 9.62278 8.53043 9.8335 8 9.8335C7.46957 9.8335 6.96086 9.62278 6.58579 9.24771C6.21071 8.87264 6 8.36393 6 7.8335C6 7.30306 6.21071 6.79436 6.58579 6.41928C6.96086 6.04421 7.46957 5.8335 8 5.8335C8.53043 5.8335 9.03914 6.04421 9.41421 6.41928C9.78929 6.79436 10 7.30306 10 7.8335V7.8335Z"
                      stroke="white"
                      stroke-width="1.33333"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                 Bàn {{$table->name}}
                </span>
            </div>
            <div class="cart-icon">
             
                <a href="/customer/cart/show/{{$table->id}}/">  <span class="icon-buy" style="font-size: 2rem;color: #fff;"></span> </a>
                <span id="cart-count">{{$cart_count}}</span>
            </div>
            
        </div>
      <div class="tf-container pt-100 pb-70">
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
              {{-- <div class="swiper-slide">
                <a href="nearby.html" class="box-categories primary">
                  <div class="images">
                    <img
                      src="images/food/coffea-sm-2.png"
                      alt="images"
                    />
                  </div>
                  <span>Popular</span>
                </a>
              </div>
              <div class="swiper-slide">
                <a href="nearby.html" class="box-categories primary">
                  <div class="images">
                    <img
                      src="images/food/coffea-sm-3.png"
                      alt="images"
                    />
                  </div>
                  <span>Milk Tea</span>
                </a>
              </div>
              <div class="swiper-slide">
                <a href="nearby.html" class="box-categories primary">
                  <div class="images">
                    <img
                      src="images/food/coffea-sm-4.png"
                      alt="images"
                    />
                  </div>
                  <span>Popular</span>
                </a>
              </div> --}}
          
        <div class="section bg">
          <div class="title-bar">
              <h2>Đồ uống bán chạy</h2>
              {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#modalRightFull">Xem thêm<i class="icon-right"></i></a> --}}
          </div>
          <div class="wrap-swiper">
              <div class="swiper drink-swiper">
                  <div class="swiper-wrapper pb-30 pt-12">
                    @foreach($topProducts as $val)
                      <div class="swiper-slide ml-2">
                          <div class="box-collections">
                              <div class="images">
                               
                                    <img src="/{{$val->thumb}}" alt="img" >
                           
                              </div>
                              <div class="content">
                                <h5><a ></a>{{$val->name}}</a> </h5>
                                <ul class="review">
                                    <li>
                                       
                                        <i class="icon-star"></i>
                                        <span><?php  $decodedHtmlContent = html_entity_decode($val->content);
                                            echo $decodedHtmlContent; ?></span>&nbsp;</li>
                                </ul>
                                <div class="box-price">
                                    <ul class="price">
                                        <li class="accent">{{$val->price}}đ</li>
                                        {{-- <li class="del">$12.48</li> --}}
                                    </ul>
                                    <button type="button" class="btn-add" data-name="p-{{$val->id}}" onclick="openQuickView(this)">+</button>
                              </div>
                          </div>
                      </div>
                      </div>
                      
                   @endforeach
                      {{-- <div class="swiper-slide">
                          <div class="box-collections">
                              <div class="images">
                                  <a href="product-details-3.html">
                                      <img src="images/food/collect-3.jpg" alt="images">
                                  </a>
                              </div>
                              <div class="content">
                                  <h3>
                                      <a href="product-details-3.html">White coffee</a>
                                  </h3>
                                  <p>32 Product</p>
                              </div>
                          </div>
                      </div> --}}

                  </div>
              </div>
          </div>
        </div>  
        {{-- <div class="section">
          <div class="title-bar">
            <h2>Coffee for you</h2>
            <a href="#" data-bs-toggle="modal" data-bs-target="#modalRightFull">View all <i class="icon-right"></i></a>
          </div>
          <div class="wrap-swiper">
            <div class="swiper drink-swiper">
              <div class="swiper-wrapper pb-30 pt-12">
                <div class="swiper-slide ml-2">
                  <div class="tf-box-column lg">
                    <div class="img-box">
                      <img src="images/food/coffea-lg-2.jpg" alt="img" />
                    </div>
                    <div class="content-box">
                      <h3><a href="product-details-1.html"> Dalgona Coffee</a></h3>
                      <ul class="review">
                        <li>
                          <i class="icon-star"></i>
                          <span>4.8</span>&nbsp; (125)
                        </li>
                        <li class="dot-icon"></li>
                        <li>16 min</li>
                      </ul>
                      <div class="box-price">
                        <span class="price">$10.48</span>
                        <a href="cart.html" class="btn-add">+</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="tf-box-column lg">
                    <div class="img-box">
                      <img src="images/food/coffea-lg-1.jpg" alt="img" />
                    </div>
                    <div class="content-box">
                      <h3><a href="product-details-1.html"> Cappuccino</a></h3>
                      <ul class="review">
                        <li>
                          <i class="icon-star"></i>
                          <span>4.8</span>&nbsp; (125)
                        </li>
                        <li class="dot-icon"></li>
                        <li>16 min</li>
                      </ul>
                      <div class="box-price">
                        <span class="price">$10.48</span>
                        <a href="cart.html" class="btn-add">+</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="section">
          <div class="title-bar">
                  <h2>Special offer
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_1105_10859)">
                        <path d="M19.0808 10.0007L19.9582 7.71211C20.0545 7.45962 19.9795 7.17339 19.7682 7.00216L17.8659 5.45976L17.4809 3.03868C17.4384 2.7712 17.2284 2.56246 16.9609 2.51996L14.5398 2.13499L12.9987 0.231369C12.8287 0.0201334 12.5362 -0.0548614 12.29 0.041382L10.0001 0.920072L7.71155 0.0426319C7.45782 -0.0548614 7.17409 0.0226333 7.00285 0.232619L5.46045 2.13624L3.03937 2.52121C2.77314 2.56371 2.56315 2.7737 2.52065 3.03993L2.13568 5.46101L0.23206 7.00341C0.0220746 7.17339 -0.0541702 7.45962 0.0420732 7.71211L0.919513 10.0007L0.0420732 12.2893C-0.0554201 12.5418 0.0220746 12.828 0.23206 12.998L2.13568 14.5391L2.52065 16.9602C2.56315 17.2277 2.77189 17.4377 3.03937 17.4802L5.46045 17.8652L7.00285 19.7675C7.17409 19.98 7.46032 20.055 7.7128 19.9575L10.0001 19.0813L12.2887 19.9588C12.3612 19.9863 12.4362 20 12.5125 20C12.6962 20 12.8774 19.9188 12.9987 19.7675L14.5398 17.8652L16.9609 17.4802C17.2284 17.4377 17.4384 17.2277 17.4809 16.9602L17.8659 14.5391L19.7682 12.998C19.9795 12.8268 20.0545 12.5418 19.9582 12.2893L19.0808 10.0007Z" fill="#FFC700"/>
                        <path d="M8.12524 8.75121C7.09156 8.75121 6.25037 7.91002 6.25037 6.87634C6.25037 5.84266 7.09156 5.00146 8.12524 5.00146C9.15892 5.00146 10.0001 5.84266 10.0001 6.87634C10.0001 7.91002 9.15892 8.75121 8.12524 8.75121ZM8.12524 6.25138C7.78026 6.25138 7.50028 6.53136 7.50028 6.87634C7.50028 7.22131 7.78026 7.50129 8.12524 7.50129C8.47021 7.50129 8.7502 7.22131 8.7502 6.87634C8.7502 6.53136 8.47021 6.25138 8.12524 6.25138Z" fill="#FAFAFA"/>
                        <path d="M11.875 15.0002C10.8413 15.0002 10.0001 14.159 10.0001 13.1254C10.0001 12.0917 10.8413 11.2505 11.875 11.2505C12.9087 11.2505 13.7499 12.0917 13.7499 13.1254C13.7499 14.159 12.9087 15.0002 11.875 15.0002ZM11.875 12.5004C11.5313 12.5004 11.25 12.7816 11.25 13.1254C11.25 13.4691 11.5313 13.7503 11.875 13.7503C12.2187 13.7503 12.5 13.4691 12.5 13.1254C12.5 12.7816 12.2187 12.5004 11.875 12.5004Z" fill="#FAFAFA"/>
                        <path d="M6.87526 15.0005C6.74901 15.0005 6.62277 14.963 6.51278 14.8843C6.23155 14.683 6.16655 14.293 6.36779 14.0118L12.6174 5.26241C12.8186 4.98118 13.2086 4.91619 13.4898 5.11742C13.771 5.31741 13.8348 5.70863 13.6348 5.98861L7.38522 14.738C7.26148 14.9093 7.07024 15.0005 6.87526 15.0005Z" fill="#FAFAFA"/>
                      </g>
                      <defs>
                        <clipPath id="clip0_1105_10859">
                          <rect width="20" height="20" fill="white"/>
                        </clipPath>
                      </defs>
                      </svg> 
                  </h2>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#modalRightFull">View all <i class="icon-right"></i></a>
          </div>
          <div class="wrap-swiper">
                  <div class="swiper drink-swiper">
                      <div class="swiper-wrapper pb-30 pt-12">
                          <div class="swiper-slide ml-2">
                              <div class="tf-box-column md">
                                  <a href="product-details-1.html" class="img-box">
                                      <img src="images/food/coffea-md-1.jpg" alt="img">
                                  </a>
                                  <div class="content-box">
                                      <h3><a href="product-details-1.html"> Cappuccino</a></h3>
                                      <ul class="review">
                                          <li>
                                              <i class="icon-star"></i>
                                              <span>4.8</span>&nbsp;
                                              (125)
                                          </li>
                                          <li class="dot-icon">
                                          </li>
                                          <li>16 min</li>
                                      </ul>
                                      <div class="box-price">
                                          <ul class="price">
                                              <li class="accent">$10.48</li>
                                              <li class="del">$12.48</li>
                                          </ul>
                                          <a href="cart.html" class="btn-add">+</a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="swiper-slide">
                              <div class="tf-box-column md">
                                  <a href="product-details-2.html" class="img-box">
                                      <img src="images/food/coffea-md-2.jpg" alt="img">
                                  </a>
                                  <div class="content-box">
                                      <h3><a href="product-details-2.html"> Cappuccino</a></h3>
                                      <ul class="review">
                                          <li>
                                              <i class="icon-star"></i>
                                              <span>4.8</span>&nbsp;
                                              (125)
                                          </li>
                                          <li class="dot-icon">
                                          </li>
                                          <li>16 min</li>
                                      </ul>
                                      <div class="box-price">
                                          <ul class="price">
                                              <li class="accent">$10.48</li>
                                              <li class="del">$12.48</li>
                                          </ul>
                                          <a href="cart.html" class="btn-add">+</a>
                                      </div>
                                    
                      
                                  </div>
                      
                              </div>
                          </div>
                          <div class="swiper-slide">
                              <div class="tf-box-column md">
                                  <a href="product-details-3.html" class="img-box">
                                      <img src="images/food/coffea-lg-1.jpg" alt="img">
                                  </a>
                                  <div class="content-box">
                                      <h3><a href="product-details-3.html"> Cappuccino</a></h3>
                                      <ul class="review">
                                          <li>
                                              <i class="icon-star"></i>
                                              <span>4.8</span>&nbsp;
                                              (125)
                                          </li>
                                          <li class="dot-icon">
                                          </li>
                                          <li>16 min</li>
                                      </ul>
                                      <div class="box-price">
                                          <ul class="price">
                                              <li class="accent">$10.48</li>
                                              <li class="del">$12.48</li>
                                          </ul>
                                          <a href="cart.html" class="btn-add">+</a>
                                      </div>
                                    
                      
                                  </div>
                      
                              </div>
                          </div>
  
                      </div>
                  </div>
          </div>
        </div>
        <div class="section recomand-sec">
          <div class="wrap-swiper">
                  <div class="swiper recomand-swiper">
                      <div class="swiper-wrapper pb-30">
                          <div class="swiper-slide ml-2">
                              <div class="recomand-box">
                                  <div class="img-box">
                                      <a href="product-details-1.html" class="bg">
                                         <img src="images/food/recomand4.jpg" alt="image">
                                      </a>
                                      <a href="product-details-1.html" class="logo">
                                          <img src="images/food/recomand-logo-2.png"  alt="image">
                                      </a>

                                  </div>

                              </div>
                          </div>
                          <div class="swiper-slide">
                              <div class="recomand-box">
                                  <div class="img-box">
                                      <a href="product-details-1.html" class="bg">
                                         <img src="images/food/recomand2.jpg" alt="image">
                                      </a>
                                      <a href="product-details-1.html" class="logo">
                                          <img src="images/food/recomand-logo-2.png"  alt="image">
                                      </a>

                                  </div>

                              </div>
                          </div>
                          <div class="swiper-slide">
                              <div class="recomand-box">
                                  <div class="img-box">
                                      <a href="product-details-1.html" class="bg">
                                         <img src="images/food/recomand3.jpg" alt="image">
                                      </a>
                                      <a href="product-details-1.html" class="logo">
                                          <img src="images/food/recomand-logo-2.png"  alt="image">
                                      </a>

                                  </div>

                              </div>
                          </div>
  
                      </div>
                  </div>
          </div>
          
        </div> --}}
        <div class="section">
            <ul class="nav nav-tabs mb-12" id="navtabs-drink1" role="tablist">
                <?php $i = 0; ?>
                @foreach ($menus as $item)
                @if($i == 0)     
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#menu{{$item->id}}"  role="tab" aria-controls="{{$item->name}}" aria-selected="true">{{$item->name}}</a>                             
                   </li>
                   <?php $i++; ?>                                           
                @else                             
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#menu{{$item->id}}" role="tab" aria-controls="{{$item->name}}" aria-selected="false">{{$item->name}}</a>
                  </li> 
                @endIF   
                @endforeach               
                
               
                 
                  
              </ul>
              <div class="tab-content">
                <?php $j = 0; ?>
                @foreach ($menus as $item)
                @if($j == 0)                
                <ul class="tab-pane fade show active" id="menu{{$item->id}}" role="tabpanel">
                    @foreach ($products as $product)
                        @if($product->menu_id == $item->id)
                        <li class="tf-box-row mb-12">
                            <a href="" class="img-box">
                                <img src="/{{$product->thumb}}" alt="img" >
                            </a>
                            <div class="content-box">
                                <h5><a href=""></a>{{$product->name}}</a> </h5>
                                <ul class="review">
                                    <li>
                                       
                                        <i class="icon-star"></i>
                                        <span><?php  $decodedHtmlContent = html_entity_decode($product->content);
                                            echo $decodedHtmlContent; ?></span>&nbsp;</li>
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
                    
                        @endif
                    @endforeach
                    @foreach ($child as $menuChild)
                        @if($menuChild->parent_id == $item->id)
                        <h3>{{$menuChild->name}}</h3>
                        @foreach ($products as $product)
                            @if($product->menu_id == $menuChild->id)
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
                         
                            @endif
                        @endforeach
                        @endif
                    @endforeach   
                    <?php $j++ ?>                                              
                </ul>
                @elseif( $j != 0)
                <ul class="tab-pane fade" id="menu{{$item->id}}" role="tabpanel">
                    @foreach ($products as $product)
                    @if($product->menu_id == $item->id)
                    
                    <li class="tf-box-row mb-12" >
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
             
                  
           
                    @endif
                @endforeach
                @foreach ($child as $menuChild)
                    @if($menuChild->parent_id == $item->id)
                    <h3>{{$menuChild->name}}</h3>
                    @foreach ($products as $product)
                        @if($product->menu_id == $menuChild->id)
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
                      
                        @endif
                    @endforeach
                    @endif
                @endforeach                         
                </ul>
                @endif
                @endforeach
        

              </div>

        </div>
      </div>
     
    </div>


 <a href="/customer/call/{{$table->id}}" id="callEmployeeButton" style="font-size: 16px">      
 
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
              <a  data-id="{{$product->id}}" data-name="p-{{$product->id}}"  class="cart-love"> <i class="far fa-heart"></i>&nbsp;Thêm vào đồ uống ưa thích</a>
           </div>
           
        </form>
        </div>
        
    </div>
    @endforeach

    <div class="menubar-footer footer-fixed">
      <ul class="inner">
        <li class="active">
          <a href="/customer/order/{{$table->id}}/"><span class="icon-home"></span> Trang chủ</a>
        </li>
        <li>
          <a href="/customer/discountIndex/{{$table->id}}"><span class="icon-discovery"></span> Khuyễn mãi</a>
        </li>
        <li>
          <a href="/customer/cart/show/{{$table->id}}/"><span class="icon-buy"></span> Giỏ hàng</a>
        </li>
        <li>
          <a href="/customer/indexListLove/{{$table->id}}"><span class="icon-heart"></span> Ưa thích</a>
        </li>
        <li>
          <a href="/customer/profile/{{$table->id}}"><span class="icon-profile"></span> Cá nhân</a>
        </li>
      </ul>
    </div>
    <div id="myModal" class="modal-fade">
      <div class="modal-content">
          <span class="close" id="closeModalBtn">&times;</span>
          <h2>Kết quả tìm kiếm</h2>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif
@if(Session::has('error'))
<script>toastr.error("{{Session::get('error')}}");</script>
@endIF
  
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
            var table_id = {{$table->id}};
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
                        window.location.href = "{{url('customer/cart/show')}}"+'/'+{{$table->id}};
                        
                    }
                    
                        });
                    



                },
                error: function (error) {
                    alert("thêm giỏ hàng thất bại");
            }
            });
          });
          $('.cart-love').click(function(){
           var table_id = {{$table->id}};
            var id = $(this).data('id');
          
            $.ajax({
              headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
                url:  "/customer/loveList/" + table_id,
                method: 'GET',
                data:{product_id:id},
                success:function(data){
                  if(data.error == false){
                    toastr.success("Thêm vào danh sách đồ uống thành công");
                  }
                  else if(data.error == 1){
                    toastr.info('Đồ uống đã có trong danh sách ưa thích');
                  //   Swal.fire({
                  //   position: "top-end",
                  //   icon: "info",
                  //   title: "Đồ uống đã có trong danh sách ưa thích",
                  //   showConfirmButton: false,
                  //   timer: 1500
                  // });
                  }
                  else{
                 
                    Swal.fire({
                    title: "Bạn cần đăng nhập để lưu đồ uống ưa thích",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonText: "Đăng nhập",
                    cancelButtonText: "Ở lại"
                    }).then((result) => {
                         /* Read more about isConfirmed, isDenied below */
                  
                     if (result.isConfirmed) {
                      window.location.href = '/customer/login/'+ table_id;
                        
                    }
                    
                        });
                   
                    
                  }
                    
                },
                error: function (error) {
                    alert("Thêm đồ uống ưa thích thất bại");
            }
            });
          });
        }); 

    

      </script>
  </body>

<!-- Mirrored from themesflat.co/html/coffeemonster/coffeeMonster-drink-app/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Nov 2023 07:55:02 GMT -->
</html>
