<!DOCTYPE html>
<html lang="en">
<head>
  @vite('resources/js/app.js')
    @include('admin.head')
  
</head>
<body class="hold-transition sidebar-mini">
  <audio id="myAudio2">
    <source src="/template/admin/dist/mp3/tiengchuong.mp3" type="audio/mpeg">
</audio>
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

        @include('admin.alert')
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                
                <h3 class="card-title">{{$title}}</h3>
                <div class="card-tools">
                  @yield('tools')
                </div>
              </div>

              @yield('content')
            
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-12">
            @yield('content1')
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
        <img src="/template/admin/dist/img/logocafe2.png" alt="AdminLTE Logo"  style="height: 20px;width: 30px;">
      </p>
     
    </div>
  
      <strong> Thời Gian © 2023-2024 </strong> 
 
   
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  {{-- <div id="sidebar-overlay"></div>
</div> --}}
<!-- ./wrapper -->

@include('admin.footer')
@stack('scripts')
<script type="module">
   
  Echo.private('OrderChannel')
  .listen('NewOrder', (e) => {
    var x = document.getElementById('myAudio');
    x.autoplay = true;
    x.load();
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
  <script type="module">
 
    Echo.private('payChannel')
     .listen('payOrder', (e) => {
     
      // if({{$users->id}} != +e.user_id){
        toastr.success("Thanh toán đơn "+e.o.id);
      var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Thanh toán đơn số "+e.o.id+    
            "<span class=\"float-right text-muted text-sm\">"+"vừa xong"
            "</span>"+"</a>";
  d.innerHTML += html;
  var num = document.getElementById('newNumber');
    var count = num.getAttribute("data-count");
  
   
      var result =Number(count) + 1;
      num.setAttribute("data-count", result);
      num.innerHTML = result;
  //   }else{
      
       
  //      Swal.fire({
  
  // title: "Đã thanh toán đơn "+e.o.id,
  // icon: "success",                         
  // confirmButtonText: "In đơn hàng"                  
  // }).then((result) => {
  // /* Read more about isConfirmed, isDenied below */
  // if(result.isConfirmed){
  //   var id = e.o.id;
  //   $.ajax({ 
  //     headers: {
  //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //         },
  //             method: 'POST',
  //             datatype: 'JSON',
  //             data: {id:id},
  //             url: '{{URL::to('/pay/revenue/exportPdf/')}}',
  //             success: function(result){
  //                if(result.error == false){
                
  //                }else{
  //                 alert('Lỗi vui lòng thử lại');
  //                }
  //             },error: function(){
  //               alert('Lỗi vui lòng thử lại');
  //             }
          
  //           });
  // }

  // });
  //   }
 
   
  })
  
  </script>

  <script type="module">

Echo.private('confirmAllDetails')
     .listen('confirmAllDetail', (e) => {
      var x = document.getElementById('myAudio1');
        x.autoplay = true;
        x.load();
      toastr.success("Duyệt toàn bộ đơn "+e.o.id);
      var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Duyệt toàn bộ đơn "+e.o.id+    
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
      Echo.private('CusOrderChannel')
      .listen('cusOrder', (e) => {

        var x = document.getElementById('myAudio');
      x.autoplay = true;
      x.load();
        toastr.success("Khách order đơn tại bàn "+ e.o.table.name);
 var d = document.getElementById("real_time");
 var html = "<div class=\"dropdown-divider\">"+"</div>"+
            "<a href=\"#\" class=\"dropdown-item\">"+"Khách order đơn tại bàn "+e.o.table.name+    
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
  Echo.private('CusCallChannel')
  .listen('cusCall', (e) => {

    var x = document.getElementById('myAudio2');
  x.autoplay = true;
  x.load();
    toastr.success("Khách gọi nhân viên bàn "+ e.table.name);
var d = document.getElementById("real_time");
var html = "<div class=\"dropdown-divider\">"+"</div>"+
        "<a href=\"#\" class=\"dropdown-item\">"+"Khách gọi nhân viên bàn "+e.table.name+    
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
