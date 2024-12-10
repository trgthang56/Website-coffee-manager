<!DOCTYPE html>
<html lang="en">
<head>
  @vite('resources/js/app.js')
    @include('admin.head')
    <style>
  table {
  border-collapse: collapse;
  table-layout: fixed;
}

th, td {
  text-align: left;
  padding: 8px;
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
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
   
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
               
              @include('admin.alert')   
                <div class="card-header">
                    <h3 class="card-title">Dánh sách tài khoản</h3>
    
                    <div class="card-tools">
                      <div class="input-group input-group-sm" style="width: 150px;">
                        <form action="/searchAcc/" method="GET" >
                                     
                        <div class="input-group-append">
                          <input type="text" name="key" class="form-control float-right" style="width: 115px;" placeholder="Tìm kiếm" required>    
                          <button type="submit" class="btn btn-default">
                            <i class="fas fa-search" ></i>
                          </button>
                          @csrf
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                                                               
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0" style="max-height: 500px;">
                    <table  class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th style="width: 50px;">ID</th>
                          <th  style="width: 150px;">Họ tên</th>
                          <th>Ngày sinh</th>
                          <th>Số điện thoại</th>
                          <th  style="width: 300px;">Địa chỉ</th>
                          <th  style="width: 200px;">Email</th>
                          <th>Vị trí</th>
                          <th style="text-align: center">Lương</th>
                          <th>Chức năng</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($users->role==0)
                        @foreach ($userAll as $us)
                        @if($us->role == 0 )
                        @continue
                        @endif
                        <tr>

                            <td>{{$us->id}}</td>
                            <td>{{$us->name}}</td>
                            <td><?php  $timestamp = strtotime($us->date_of_birth);  $date = date('d/m/Y', $timestamp);
                              echo $date;?></td>
                              <td>{{$us->phone_number}}</td>
                            <td>{{$us->address}}</td>
                            <td >{{$us->email}}</td>
                            <td><?php if($us->role == 0) {echo'Chủ cửa hàng';}
                                elseif ($us->role == 1) {
                                echo'Quản lý';
                                }
                                elseif ($us->role == 2) {
                                echo'Nhân viên thu ngân';
                                }
                                elseif ($us->role == 3) {
                                echo'Nhân viên pha chế';
                                }
                                elseif ($us->role == 4) {
                                echo'Nhân viên chạy bàn';
                                }
                            ?></td>
                            <td style="text-align: center"><?php   $formattedNumber1 = number_format($us->salary);echo $formattedNumber1; ?>&nbsp;đ/h</td>
                            <td>
                             
                              <form method="POST" action="/deleteAcc/{{$us->id}}">
                                <a class="btn btn-primary btn-sm" href="/editAcc/{{ $us->id }}">
                                  <i class="fas fa-edit"></i>
                              </a>
                            
                              <button type="submit" class="btn btn-danger btn-sm"
                             onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản của {{$us->name}}')">
                             <i class="fas fa-trash-alt"></i></button>
                             <a class="btn  btn-success btn-sm" href="/resetPass/{{ $us->id }}" title="Khôi phục mật khẩu" >
                              <i class="fas fa-undo-alt"></i>
                            </a>
                           
                              @method('DELETE')
                              @csrf
                            </form></td>
                        </tr>
                        @endforeach
                        @endIf
                       @if($users->role == 1)
                       @foreach ($userAll as $us)
                       @if($us->role == 0 || $us->role == 1)
                       @continue
                       @endif
                       <tr>
                           <td>{{$us->id}}</td>
                           <td>{{$us->name}}</td>
                           <td></td>
                           <td></td>
                         <td></td>
                           <td >{{$us->email}}</td>
                           <td><?php if($us->role == 0) {echo'Chủ cửa hàng';}
                               elseif ($us->role == 1) {
                               echo'Quản lý';
                               }
                               elseif ($us->role == 2) {
                               echo'Nhân viên thu ngân';
                               }
                               elseif ($us->role == 3) {
                               echo'Nhân viên pha chế';
                               }
                               elseif ($us->role == 4) {
                               echo'Nhân viên chạy bàn';
                               }
                           ?></td>
                           <td></td>
                           <td>
                            
                            <form method="POST" action="/deleteAcc/{{$us->id}}">
                              <a class="btn btn-primary btn-sm" href="/editAcc/{{ $us->id }}">
                                <i class="fas fa-edit"></i>
                            </a>
                             <button type="submit" class="btn btn-danger btn-sm"
                             onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản của {{$us->name}}')">
                             <i class="fas fa-trash-alt"></i></button>
                             @method('DELETE')
                             @csrf
                           </form></td>
                       </tr>
                       @endforeach
                       @endIf
                      </tbody>
                    </table>
                  </div>
            </div>
            <button style="width: 20%;" onclick="myFunction()"  class="btn btn-block btn-info btn-mb">Tạo tài khoản</button>
         
            <div class="card card-primary">
              
                <!-- /.card-header -->
                <!-- form start -->
                <form id="form_add" style="display: none" method="POST" action="/storeAcc/" >

                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Họ tên</label>
                          <input type="text" class="form-control" name="name" placeholder="Họ tên" required>
                        </div>
                      
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="text" class="form-control" name="email" placeholder="Email" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Ngày tháng năm sinh</label>
                          <input type="date" class="form-control" name="birth" required>
                        </div> 
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Số điện thoại</label>
                          <input type="text" class="form-control" id="phoneNumber" name="phone" placeholder="SĐT" onchange="validatePhoneNumber()" required>
                        </div>
                      </div>
                     
                    </div>
                    
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label >Mật khẩu</label>
                        <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" name="confirm" placeholder="Xác nhận mật khẩu" required>
                      </div>
                    </div>
                  </div>
                  
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label >Vị trí</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" name="role" tabindex="-1" aria-hidden="true">
                                <option selected="selected" data-select2-id="3">Chạy bàn</option>
                                @if($users->role == 0)
                                <option>Quản lý</option>
                                @endIf
                                <option>Thu ngân</option>
                                <option>Pha chế</option>                                                 
                                </select>
                          </div> 
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label >Lương theo giờ</label>
                            <input type="number" class="form-control" name="salary" placeholder="Lương" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label >Địa chỉ</label>
                            <input type="text" class="form-control" name="address" placeholder="Địa chỉ" required>
                          </div>
                        </div>
                      </div>
                @csrf
                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Đăng ký</button>
                  </div>
                </form>
              </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
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

<!-- ./wrapper -->
<script>
     function myFunction() {        
          var y = document.getElementById("form_add");
          if(y.style.display === "none")
          {
            y.style.display = "block";
          }
          else if(y.style.display === "block"){
            y.style.display = "none";
          }
        }
</script>
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
