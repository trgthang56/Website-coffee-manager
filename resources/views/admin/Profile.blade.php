<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.head')
    <style>
       
       
    
        input[type=text], input[type=email], select {
          width: 100%;
          font-size:14px;
          padding: 9px 15px;
          margin: 5px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
        }
        input[type=password]{
          padding: 9px 15px;
          margin: 10px 0px;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
        }
        #send {
          background-image: linear-gradient(to right, #662D8C , #ED1E79);
          color: white;
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          cursor: pointer;
          width: 100%;
          border-radius: 5px;
        }
    
       #send {
          opacity: 0.8;
        }
        
        </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
   <!-- Left navbar links -->
   <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>

    @if($users->role != 0 && $users->role != 1)
    <form action="/attendance/checkin/" method="POST" id="checkin">
      @csrf
     
    <li class="nav-item"> 
      <button class="btn btn-block btn-success btn-sm" type="submit"><i class="fas fa-clock"></i> Bắt đầu</button>
</li>
</form>
<form action="/attendance/checkout/" method="POST" id="checkout">

<li class="nav-item"  style="margin-left: 10px">
  <button class="btn btn-block btn-danger btn-sm" type="submit"><i class="fas fa-door-open"></i> Kết thúc</button>
  
</li>
@csrf
</form>
@endIf


  </ul>
 
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
        <i class="far fa-bell"></i>
        <?php  
        $count = 0;
          foreach($newAll as $val){
           if(!in_array($users->id, $val->read_by)){
            $count++;
           }
          }
        ?>
        <span class="badge badge-warning navbar-badge">@if($count != 0) <?php echo $count; ?>@endIf</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
        <span class="dropdown-item dropdown-header">THÔNG BÁO MỚI NHẤT</span>
        <div id="real_time"></div>
        @foreach($new as $val)
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          {{$val->content}}
        <span class="float-right text-muted text-sm">
          <?php
        $currentTime = new DateTime();
        $formattedTime = $currentTime->format('Y-m-d H:i:s');
        $timestamp1 = strtotime($val->created_at);
        $timestamp2 = strtotime($formattedTime);
        $interval =  $timestamp2 - $timestamp1;
       
        $time =   App\Helpers\Helper::formatTimeDifference($interval) ;
          echo $time;
        ?>
        </span>
        </a>
        <div class="dropdown-divider"></div>
        @endforeach
        <div class="dropdown-divider"></div>
        <a href="/admin" class="dropdown-item dropdown-footer">Xem tất cả thông báo</a>
        </div>
        </li>
    
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen"  role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
     
    </ul>
  </nav>
  <!-- /.navbar -->

  @include('admin.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thông tin tài khoản</h1>
          </div>
         
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  @If($users->image === null)
                  <img class="profile-user-img img-fluid img-circle"
                       src="/template/admin/dist/img/avatar5.png"
                       alt="User profile picture">
                       @else
                       <img class="profile-user-img img-fluid img-circle"
                       src="{{$users->image}}"
                       alt="User profile picture">
                       @endif
                </div>

                <h3 class="profile-username text-center">{{$users->name}}</h3>
                <p class="text-muted text-center"><?php if($users->role == 0) {echo'Chủ cửa hàng';}
                  elseif ($users->role == 1) {
                  echo'Quản lý';
                  }
                  elseif ($users->role == 2) {
                  echo'Nhân viên thu ngân';
                  }
                  elseif ($users->role == 3) {
                  echo'Nhân viên pha chế';
                  }
                  elseif ($users->role == 4) {
                  echo'Nhân viên chạy bàn';
                  }
              ?></p>
               <p class="text-muted text-center">Lương: &nbsp;<?php   $formattedNumber1 = number_format($users->salary);echo $formattedNumber1; ?>&nbsp;đ/h</p>

             
              
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-primary">
              <div class="card-header">
              <h3 class="card-title">Thông tin cá nhân</h3>
              </div>
              
              <div class="card-body">
              <strong><i class="fas fa-envelope"></i> Email</strong>
              <p class="text-muted">
                {{$users->email}}
              </p>
              <hr>
              <strong><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ</strong>
              <p class="text-muted">{{$users->address}}</p>
              <hr>
              <strong><i class="fas fa-phone-square"></i> Số điện thoại</strong>
              <p class="text-muted">
                {{$users->phone_number}}
              </p>
              <hr>
              <strong><i class="far fa-calendar-alt"></i> Ngày sinh</strong>
              <p class="text-muted"> <?php  $timestamp = strtotime($users->date_of_birth);  $date = date('d/m/Y', $timestamp);
                echo $date;?></p>
              </div>
              
              </div>
         
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><button id="update-profile" onclick="myFunction()" class="nav-link active"  data-toggle="tab" >Sửa thông tin </button></li>
                  <li class="nav-item"><button id="update-password" onclick="doiMK()"class="nav-link active" data-toggle="tab" style="margin-left: 5px">Đổi mật khẩu</button></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity" >
                    <!-- Post -->             
                
                    @include('admin.alert')
                  </div>
                 
                  <form id="update_profile" method="POST" action="/updateAcc/" style="display: block"   enctype="multipart/form-data" >
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Họ tên</label>
                          <input id = "nameField" name="name" placeholder="Họ và tên" type="text" value="{{$users->name}}"> 
                        </div> 
                      </div>
                    
                   
                        <div class="col-md-6">
                          <div class="form-group">
                            <label >Ngày tháng năm sinh</label>
                            <input type="date" class="form-control" name="birth"  value="{{$users->date_of_birth}}">
                          </div> 
                        </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Số điện thoại</label>
                          <input type="text" class="form-control" id="phoneNumber" name="phone" placeholder="SĐT" onchange="validatePhoneNumber()"  value="{{$users->phone_number}}">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Địa chỉ</label>
                          <input type="text" class="form-control" name="address" placeholder="Địa chỉ"  value="{{$users->address}}">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Chọn ảnh đại diện :</label>
                          <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="avartarFile"   onchange="displayImage(this)" >
                            <label class="custom-file-label" for="avartarFile">Chọn file ảnh</label>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <img id="selectedImage" class="img-fluid" style="display: none;width: 100px;height: 100px;" alt="Selected Image"
                                onclick="openModal()">
                            </div>
                          </div>
                        </div>
                      </div>
                     
                    </div>
                    
                    {{-- <input id="imagename" name="image" placeholder="Ảnh" type="file" required>  --}}
                    {{-- <input id="img" name="entry.325479647" placeholder="Số điện thoại" type="text" pattern="^\d{10}$" required>   --}}
                    <button id="send" type="submit" class="common_btn">Cập nhật thông tin</button>
                    @csrf
                    </form>
                    <form id="update_password" method="POST" action="/updatePass/" style="display: none"   >          
                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password">Nhập mật khẩu cũ</label>
                                <input id="password" name="password" placeholder="Mật khẩu cũ" type="password" class="form-control" required> 
                            </div>
                        </div>
                       
                      
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="password1">Nhập mật khẩu mới :</label>
                            <input id="password1" name="password1" placeholder="Mật khẩu mới" type="password" class="form-control" required> 
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="confirm">Nhập lại mật khẩu mới :</label>
                                <input id="confirm" name="confirm" placeholder="Xác nhận" type="password" class="form-control" required> 
                            </div>
                        </div>
                    </div>
                    
                   
                    
                      {{-- <input id="img" name="entry.325479647" placeholder="Số điện thoại" type="text" pattern="^\d{10}$" required>   --}}
                      <button id="send" type="submit"  class="btn btn-success toastrDefaultSuccess">Đổi mật khẩu</button>
                      @csrf
                      </form>
              
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <p>Cà Phê Nhà Duyên
        <img src="/template/admin/dist/img/logocafe1.png" alt="AdminLTE Logo"  style="height: 20px;width: 30px;">
      </p>
     
    </div>
   
    <strong> Thời Gian © 2023-2024 </strong> 
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
     function myFunction() {
      var x = document.getElementById("update_password");        
          var y = document.getElementById("update_profile");
          if(y.style.display === "none")
          {
            x.style.display = "none"
            y.style.display = "block";
          }
          else if(y.style.display === "block"){
            y.style.display = "none";
          }
        }
        function doiMK() {
          var x = document.getElementById("update_profile");          
          var y = document.getElementById("update_password");
          if(y.style.display === "none")
          {
            x.style.display = "none";
            y.style.display = "block";
          }
          else {
            y.style.display = "none";
          }
        }
</script>
<script> 
document.getElementById('avartarFile').addEventListener('change', function (e) {
  var fileName = e.target.files[0].name;
  var label = document.querySelector('.custom-file-label');
  label.innerHTML = fileName;
});
function displayImage(input) {
  var selectedImage = document.getElementById('selectedImage');
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      selectedImage.style.display = 'block';
      selectedImage.src = e.target.result;
    };

    reader.readAsDataURL(input.files[0]);
  }
}</script>
<script type="module">
   
  Echo.private('OrderChannel')
  .listen('NewOrder', (e) => {
    toastr.success("Có đơn hàng mới tại bàn "+ e.o.table.name);
 var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Có đơn hàng mới "+e.o.id+    
            "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
            "</span>"+"</a>";
    d.innerHTML += html;
    var num = document.getElementById('newNumber');
    var count = num.getAttribute("data-count");
    if({{$users->id}} != e.user_id){
      var result =Number(count) + 1;
      num.setAttribute("data-count", result);
      num.innerHTML = result;
    }
     
    
})
</script>
<script type="module">
 
  Echo.private('updateDetails')
   .listen('updateDetail', (e) => {
    toastr.success("Cập nhật chi tiết đơn "+e.detail.order_id);
  var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Cập nhật chi tiết đơn "+e.detail.order_id+    
            "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
            "</span>"+"</a>";
    d.innerHTML += html;
    var num = document.getElementById('newNumber');
    var count = num.getAttribute("data-count");
    if({{$users->id}} != +e.user_id){
      var result =Number(count) + 1;
      num.setAttribute("data-count", result);
      num.innerHTML = result;
    }
 
})

</script>
<script type="module">
 
  Echo.private('deleteDetails')
   .listen('deleteDetail', (e) => {
    toastr.success("Xóa chi tiết đơn "+e.detail.order_id);
  
   var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Xóa chi tiết đơn "+e.detail.order_id+    
            "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
            "</span>"+"</a>";
    d.innerHTML += html;
    var num = document.getElementById('newNumber');
    var count = num.getAttribute("data-count");
    if({{$users->id}} != +e.user_id){
      var result =Number(count) + 1;
      num.setAttribute("data-count", result);
      num.innerHTML = result;
    }
   
})
</script>
<script type="module">
 
  Echo.private('deleteAllDetails')
   .listen('deleteAllDetail', (e) => {
  
    toastr.success("Xóa toàn bộ chi tiết đơn "+e.o.id);
 
  var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Xóa toàn bộ chi tiết đơn "+e.o.id+    
            "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
            "</span>"+"</a>";
    d.innerHTML += html;
 
    var num = document.getElementById('newNumber');
    var count = num.getAttribute("data-count");
    if({{$users->id}} != +e.user_id){
      var result =Number(count) + 1;
      num.setAttribute("data-count", result);
      num.innerHTML = result;
    }
 
})

</script>
<script type="module">
 
  Echo.private('cancleOrders')
   .listen('cancleOrder', (e) => {
  
  
    toastr.success("Hủy đơn "+e.o.table_id);
  var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Hủy đơn "+e.o.id+    
            "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
            "</span>"+"</a>";
  d.innerHTML += html;
     
  var num = document.getElementById('newNumber');
    var count = num.getAttribute("data-count");
    if({{$users->id}} != +e.user_id){
      var result =Number(count) + 1;
      num.setAttribute("data-count", result);
      num.innerHTML = result;
    }
 

 
})

</script>
<script type="module">
  Echo.private('finishDetails')
      .listen('finishDetail', (e) => {
      
 
      if(e.mess.status === '0'){
      
        toastr.success("Trả toàn bộ đơn "+e.o.id);

 
    
   
       
 
            
  var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Trả toàn bộ đơn "+e.o.id+    
            "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
            "</span>"+"</a>";
  d.innerHTML += html;
  var num = document.getElementById('newNumber');
    var count = num.getAttribute("data-count");
    if({{$users->id}} != +e.user_id){
      var result =Number(count) + 1;
      num.setAttribute("data-count", result);
      num.innerHTML = result;
    }
 
      }else{
        toastr.success("Trả một phần đơn "+e.o.id);
        var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Trả một phần đơn "+e.o.id+    
            "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
            "</span>"+"</a>";
  d.innerHTML += html;
  var num = document.getElementById('newNumber');
    var count = num.getAttribute("data-count");
    if({{$users->id}} != +e.user_id){
      var result =Number(count) + 1;
      num.setAttribute("data-count", result);
      num.innerHTML = result;
    }
 
            }

  
    
 
  })
   </script>
   <script type="module">
 
    Echo.private('finishAllDetails')
     .listen('finishAllDetail', (e) => {
      toastr.success("Trả toàn bộ đơn "+e.o.id);
      var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Trả toàn bộ đơn "+e.o.id+    
            "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
            "</span>"+"</a>";
  d.innerHTML += html;
  var num = document.getElementById('newNumber');
    var count = num.getAttribute("data-count");
    if({{$users->id}} != +e.user_id){
      var result =Number(count) + 1;
      num.setAttribute("data-count", result);
      num.innerHTML = result;
    }
 
   
  })
  
  </script>
  <script>
       function validatePhoneNumber() {
            var phoneNumber = document.getElementById('phoneNumber').value;
            // Xoá các ký tự không phải là số
            phoneNumber = phoneNumber.replace(/\D/g, '');

            if (phoneNumber.length != 10) {
                alert('Số điện thoại không hợp lệ');
            } 
        }
  </script>
@include('admin.footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif

<script type="module">
  Echo.private('CheckinChannel')
  .listen('Checkin', (e) => {

    if({{$users->id}} != e.user.id){
    toastr.success(e.user.name+" chấm công !");
var d = document.getElementById("real_time");
var html = "<div class=\"dropdown-divider\">"+"</div>"+
        "<a href=\"#\" class=\"dropdown-item\">"+e.user.name+" chấm công !"    
        "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
        "</span>"+"</a>";
d.innerHTML += html;
var num = document.getElementById('newNumber');
var count = num.getAttribute("data-count");

  var result =Number(count) + 1;
  num.setAttribute("data-count", result);
  num.innerHTML = result;
}

})
</script>
<script type="module">
  Echo.private('CheckoutChannel')
  .listen('Checkout', (e) => {

    if({{$users->id}} != e.user.id){
    toastr.success(e.user.name+" kết thúc !");
var d = document.getElementById("real_time");
var html = "<div class=\"dropdown-divider\">"+"</div>"+
        "<a href=\"#\" class=\"dropdown-item\">"+e.user.name+" kết thúc !"    
        "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
        "</span>"+"</a>";
d.innerHTML += html;
var num = document.getElementById('newNumber');
var count = num.getAttribute("data-count");

  var result =Number(count) + 1;
  num.setAttribute("data-count", result);
  num.innerHTML = result;
}

})
</script>

<script>
  document.getElementById("checkin").addEventListener("submit", function(event) {
      // Hiển thị hộp thoại xác nhận
      var result = confirm("Bạn muốn bắt đầu giờ làm việc ?");
      
      // Nếu người dùng nhấn OK, tiếp tục gửi form
      if (!result) {
          event.preventDefault(); // Ngăn chặn gửi form
      }
  });
  document.getElementById("checkout").addEventListener("submit", function(event) {
      // Hiển thị hộp thoại xác nhận
      var result = confirm("Bạn muốn kết thúc giờ làm việc ?");
      
      // Nếu người dùng nhấn OK, tiếp tục gửi form
      if (!result) {
          event.preventDefault(); // Ngăn chặn gửi form
      }
  });
</script>
</body>
</html>
