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
                    <h3 class="card-title">Dánh sách tài khoản khách hàng</h3>
    
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
                  <div class="card-body table-responsive p-0" style="max-height: 600px;">
                    <table class="table table-head-fixed text-nowrap">
                      <thead>
                        <tr>
                          <th style="width: 50px;">ID</th>
                          <th  >Họ tên</th>
                          <th  >Email</th>
                          <th>Vị trí</th>
                            <th>Ngày đăng ký</th>
                          <th>Chức năng</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                        @foreach ($userAll as $us)
                    
                        <tr>

                            <td>{{$us->id}}</td>
                            <td>{{$us->name}}</td>
                         
                            <td >{{$us->email}}</td>

                            <td><?php if($us->role == 5) {echo'Khách hàng tiềm năng';}
                                elseif ($us->role == 6) {echo'Khách hàng vip';
                           
                                }
                               
                            ?></td>
                             <td >{{$us->created_at}}</td>
                            <td>
                             
                              <form method="POST" action="/deleteAcc/{{$us->id}}">
                                <a class="btn btn-primary btn-sm" href="/customer/upgrade/{{ $us->id }}">
                              Nâng cấp <i class="fas fa-level-up-alt"></i>
                              </a>
                              <button type="submit" class="btn btn-danger btn-sm"
                             onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản của {{$us->name}}')">
                             <i class="fas fa-trash-alt"></i></button>
                              @method('DELETE')
                              @csrf
                            </form></td>
                        </tr>
                        @endforeach
                     
                   
                      </tbody>
                    </table>
                  </div>
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
</div>
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
</body>
</html>
