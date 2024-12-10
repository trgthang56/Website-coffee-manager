@extends('admin.main')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite('resources/js/app.js')
@endsection

@section('content')
<audio id="myAudio">
    <source src="/template/admin/dist/mp3/clock-alarm-8761.mp3" type="audio/mpeg">
</audio>
<audio id="myAudio1">
    <source src="/template/admin/dist/mp3/trado.mp3" type="audio/mpeg">
</audio>
<div class="row">
    <div class="col-12">
    <div class="card">
    <div class="card-header">
    <h3 class="card-title">Các đơn hàng mới</h3>
    <div class="card-tools">
    <div class="input-group input-group-sm" style="width: 150px;">
    <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm kiếm">
    <div class="input-group-append">
    <button type="submit" class="btn btn-default">
    <i class="fas fa-search"></i>
    </button>
    </div>
    </div>
    </div>
    </div>
    </div>
   <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap" id="orderList">
    <thead>
    <tr>
    <th>ID</th>
    <th>Người lên đơn</th>
    <th>Tên bàn</th>
    <th>Ghi chú đơn hàng</th>
    <th>Trạng thái đơn</th>
    <th>Thời gian tạo</th>
    <th>Thời gian cập nhật đơn</th>
    <th>Chi tiết</th>
    </tr>
    </thead>
    <tbody >
        @foreach ($orderNew as $item)
    <tr>
    <td >{{$item->id}}</td>
    <td >{{$item->user->name}}</td>
    <td >{{$item->table->name}} </td>
    <td >@if(empty($item->mess)) Không có ghi chú @else {{$item->mess}} @endIF</td> 
    <td >{{$item->status}}</td>
    <td >{{$item->created_at}}</td>
    <td id="update-{{$item->id}}">{{$item->updated_at}}</td>
    <td ><a class="btn btn-app"  href="/order/detail/show/{{ $item->id }}" data-id="{{$item->id}}" onclick="checked(this)">
        <i class="fas fa-edit"></i> Chi tiết
        <span class="badge bg-danger" id="new_{{$item->id}}"></span>
        </a>
        
       
     
       
    </a>
 
   
</td>
    </tr>
    @endforeach
    </tbody>
    </table>

    <div style="margin-top: 1%;">
        {{$orderNew->appends(request()->all())->links()}}
      </div>
    </div>

    

    
   
    
    </div>
    </div>
    

@endsection
@section('footer')
<script>
    function checked(event){
     id = event.getAttribute("data-id");
    var news = document.getElementById("new_"+id);
    news.innerHTML = '';
    
    }
    function addLeadingZero(number) {
  // Hàm này thêm số 0 ở trước nếu giá trị dưới 10
  return number < 10 ? '0' + number : number;
}    
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>

@endif

@endsection
@push('scripts')

<script type="module">
  

   
 

    
Echo.private('OrderChannel')
.listen('NewOrder', (e) => {
   
    var count = 0;
    var table = document.getElementById("orderList");
    var a = e.o.id;
    for (var i = 1, row; row = table.rows[i]; i++) {
    // Duyệt qua từng ô trong hàng
        var cell = row.cells[0];
       
         if(cell.innerHTML == a){
         count++;
         break;
        }
    }
if(count != 0){
    var today = new Date();
    var hours = today.getHours();
  var minutes = today.getMinutes();
  var seconds = today.getSeconds();

  // Thêm số 0 ở trước nếu giá trị dưới 10
  hours = addLeadingZero(hours);
  minutes = addLeadingZero(minutes);
  seconds = addLeadingZero(seconds);
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+' '+hours + ":" + minutes + ":" + seconds;
    var update = document.getElementById("update-"+e.o.id);
    var news = document.getElementById("new_"+e.o.id);
    update.innerHTML = date;
    news.innerHTML = 'Mới';
    
    
}
else{
    // var id = document.getElementById("order-"+e.o.id);
    // var user = document.getElementById("user-"+e.o.id);
    // var table = document.getElementById("tabble-"+e.o.id);
    // var mess = document.getElementById("mess-"+e.o.id);
    // var status = document.getElementById("status-"+e.o.id);
    // var create = document.getElementById("create-"+e.o.id);
    // var update = document.getElementById("update-"+e.o.id);
    // var button = document.getElementById("button-"+e.o.id);
    var today = new Date();
    var hours = today.getHours();
  var minutes = today.getMinutes();
  var seconds = today.getSeconds();

  // Thêm số 0 ở trước nếu giá trị dưới 10
  hours = addLeadingZero(hours);
  minutes = addLeadingZero(minutes);
  seconds = addLeadingZero(seconds);
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+' '+hours + ":" + minutes + ":" + seconds;
    
// Thêm một hàng mới vào 
    var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    var count1 ;
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");             
                if(parseInt(cells[0].innerHTML, 10) > e.o.id){
                count1 = i+1;
                break;
                }

            }
var newRow = table.tBodies[0].insertRow(count1);

// Thêm ô (cell) vào hàng mới
var cell1 = newRow.insertCell(0);
var cell2 = newRow.insertCell(1);
var cell3 = newRow.insertCell(2);
var cell4 = newRow.insertCell(3);
var cell5 = newRow.insertCell(4);
var cell6 = newRow.insertCell(5);
var cell7 = newRow.insertCell(6);
var cell8 = newRow.insertCell(7);
// Thiết lập nội dung cho ô mới
cell1.innerHTML = e.o.id;
cell2.innerHTML = e.o.user.name;
cell3.innerHTML = e.o.table.name;
if(e.o.mess === '') { cell4.innerHTML = "Không có ghi chú";}else {cell4.innerHTML = e.o.mess;}
cell5.innerHTML = e.o.status;
cell6.innerHTML = date;
cell7.innerHTML = date;
var html = '<a class=\"btn btn-app\"  href=\"/order/detail/show/'+e.o.id+'\" data-id=\"'+e.o.id+'\" onclick=\"checked(this)\">'+'<i class=\"fas fa-edit\"></i> Chi tiết'+'<span class=\"badge bg-danger\" id=\"new_'+e.o.id+'\">Mới</span>'
      +'</a>';
cell8.innerHTML = html;


}
   
    
})

</script>


 
<script type="module">
   
    Echo.private('confirmAllDetails')
     .listen('confirmAllDetail', (e) => {
     
     
   
        var count = 0;
    var table = document.getElementById("orderList");
    var a = e.o.id;
    for (var i = 1, row; row = table.rows[i]; i++) {
    // Duyệt qua từng ô trong hàng
        var cell = row.cells[0];
       
         if(cell.innerHTML == a){
         count++;
         break;
        }
    }
if(count != 0){
    var today = new Date();
    var hours = today.getHours();
  var minutes = today.getMinutes();
  var seconds = today.getSeconds();

  // Thêm số 0 ở trước nếu giá trị dưới 10
  hours = addLeadingZero(hours);
  minutes = addLeadingZero(minutes);
  seconds = addLeadingZero(seconds);
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+' '+hours + ":" + minutes + ":" + seconds;
    var update = document.getElementById("update-"+e.o.id);
    var news = document.getElementById("new_"+e.o.id);
    update.innerHTML = date;
    news.innerHTML = 'Mới';
    
    
}
else{
    // var id = document.getElementById("order-"+e.o.id);
    // var user = document.getElementById("user-"+e.o.id);
    // var table = document.getElementById("tabble-"+e.o.id);
    // var mess = document.getElementById("mess-"+e.o.id);
    // var status = document.getElementById("status-"+e.o.id);
    // var create = document.getElementById("create-"+e.o.id);
    // var update = document.getElementById("update-"+e.o.id);
    // var button = document.getElementById("button-"+e.o.id);
    var today = new Date();
    var hours = today.getHours();
  var minutes = today.getMinutes();
  var seconds = today.getSeconds();

  // Thêm số 0 ở trước nếu giá trị dưới 10
  hours = addLeadingZero(hours);
  minutes = addLeadingZero(minutes);
  seconds = addLeadingZero(seconds);
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+' '+hours + ":" + minutes + ":" + seconds;
    
// Thêm một hàng mới vào 
    var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    var count1 ;
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");             
                if(parseInt(cells[0].innerHTML, 10) > e.o.id){
                count1 = i+1;
                break;
                }

            }
var newRow = table.tBodies[0].insertRow(count1);

// Thêm ô (cell) vào hàng mới
var cell1 = newRow.insertCell(0);
var cell2 = newRow.insertCell(1);
var cell3 = newRow.insertCell(2);
var cell4 = newRow.insertCell(3);
var cell5 = newRow.insertCell(4);
var cell6 = newRow.insertCell(5);
var cell7 = newRow.insertCell(6);
var cell8 = newRow.insertCell(7);
// Thiết lập nội dung cho ô mới
cell1.innerHTML = e.o.id;
cell2.innerHTML = e.o.user.name;
cell3.innerHTML = e.o.table.name;
if(e.o.mess === '') { cell4.innerHTML = "Không có ghi chú";}else {cell4.innerHTML = e.o.mess;}
cell5.innerHTML = e.o.status;
cell6.innerHTML = date;
cell7.innerHTML = date;
var html = '<a class=\"btn btn-app\"  href=\"/order/detail/show/'+e.o.id+'\" data-id=\"'+e.o.id+'\" onclick=\"checked(this)\">'+'<i class=\"fas fa-edit\"></i> Chi tiết'+'<span class=\"badge bg-danger\" id=\"new_'+e.o.id+'\">Mới</span>'
      +'</a>';
cell8.innerHTML = html;


}
    
  
   
  })
  
  </script>
<script type="module">
    
 Echo.private('updateDetails')
    .listen('updateDetail', (e) => {
    var today = new Date();
    var hours = today.getHours();
  var minutes = today.getMinutes();
  var seconds = today.getSeconds();

  // Thêm số 0 ở trước nếu giá trị dưới 10
  hours = addLeadingZero(hours);
  minutes = addLeadingZero(minutes);
  seconds = addLeadingZero(seconds);
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+' '+hours + ":" + minutes + ":" + seconds;
    var update = document.getElementById("update-"+e.detail.order_id);
    var news = document.getElementById("new_"+e.detail.order_id);
     update.innerHTML = date;
    news.innerHTML = 'Cập nhật';
})
 </script>

 <script type="module">
Echo.private('finishDetails')
    .listen('finishDetail', (e) => {
        var x = document.getElementById('myAudio1');
      x.autoplay = true;
      x.load();
        if(e.mess.status === '0'){
            
          
            var table = document.getElementById("orderList");
             var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");             
                if(cells[0].innerHTML == e.o.id){
                table.deleteRow(i+1);
                break;
                }

            }
        }else{
          
            var news = document.getElementById("new_"+e.o.id);
            news.innerHTML = 'Trả đồ';
            var today = new Date();
            var hours = today.getHours();
            var minutes = today.getMinutes();
            var seconds = today.getSeconds();

  // Thêm số 0 ở trước nếu giá trị dưới 10
             hours = addLeadingZero(hours);
             minutes = addLeadingZero(minutes);
             seconds = addLeadingZero(seconds);
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+' '+hours + ":" + minutes + ":" + seconds;
             var update = document.getElementById("update-"+e.o.id);
   
            update.innerHTML = date;

        }
        
   
  
    var x = document.getElementById('myAudio1');
    x.autoplay = true;
    x.load();
   
})
 </script>
<script type="module">
 
    Echo.private('cancleOrders')
     .listen('cancleOrder', (e) => {
   
     var table = document.getElementById("orderList");
             var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");             
                if(cells[0].innerHTML == e.o.id){
                table.deleteRow(i+1);
                break;
                }

            }
  
   
  })
  
  </script>
<script type="module">
    Echo.private('deleteDetails')
        .listen('deleteDetail', (e) => {
  
    if(e.detail.status === 'Chưa thanh toán'){
    var table = document.getElementById("orderList");
    var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");             
                if(cells[0].innerHTML == e.detail.order_id){
                table.deleteRow(i+1);
                break;
                }

            }
    }else{
            var news = document.getElementById("new_"+e.detail.order_id);
            news.innerHTML = 'Xóa chi tiết';
            var today = new Date();
            var hours = today.getHours();
            var minutes = today.getMinutes();
            var seconds = today.getSeconds();

  // Thêm số 0 ở trước nếu giá trị dưới 10
             hours = addLeadingZero(hours);
             minutes = addLeadingZero(minutes);
             seconds = addLeadingZero(seconds);
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+' '+hours + ":" + minutes + ":" + seconds;
             var update = document.getElementById("update-"+e.detail.order_id);
   
            update.innerHTML = date;
    }
    })
     </script>


<script type="module">
 
    Echo.private('deleteAllDetails')
     .listen('deleteAllDetail', (e) => {
   
       if(e.o.status === 'Chưa thanh toán'){
             var table = document.getElementById("orderList");
             var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");             
                if(cells[0].innerHTML == e.o.id){
                table.deleteRow(i+1);
                break;
                }

            }
       }
    
  
   
  })
  
  </script>
  <script type="module">
  
    
    Echo.private('finishAllDetails')
     .listen('finishAllDetail', (e) => {
        var x = document.getElementById('myAudio1');
      x.autoplay = true;
      x.load();
    
            var table = document.getElementById("orderList");
             var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");      
                console.log("Thành công");       
                if(cells[0].innerHTML == e.o.id){
                table.deleteRow(i+1);
                break;
                }

            }
  
   
  })
  
  </script>
@endpush