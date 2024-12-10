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
    <h3 class="card-title">Các đơn hàng đã hủy</h3>
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
    <th>Thời gian hủy đơn</th>
    <th>Chi tiết</th>
    </tr>
    </thead>
    <tbody >
        @foreach ($orderCancle as $item)
    <tr>
    <td >{{$item->id}}</td>
    <td > @if($item->user_id == 0) Khách order @else {{$item->user->name}} @endIF</td>
    <td >{{$item->table->name}} </td>
    <td >@if(empty($item->mess)) Không có ghi chú @else {{$item->mess}} @endIF</td> 
    <td >{{$item->status}}</td>
    <td >{{$item->created_at}}</td>
    <td id="update-{{$item->id}}">{{$item->updated_at}}</td>
    <td ><a class="btn btn-app"  href="/order/detailCancle/show/{{ $item->id }}" data-id="{{$item->id}}" >
        <i class="fas fa-edit"></i> Chi tiết
        </a>
        
       
     
       
    </a>
 
   
</td>
    </tr>
    @endforeach
    </tbody>
    </table>

    <div style="margin-top: 1%;">
        {{$orderCancle->appends(request()->all())->links()}}
      </div>
    </div>

    

    
   
    
    </div>
    </div>
    

@endsection
@section('footer')
<script>
   
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
 
    Echo.private('cancleOrders')
     .listen('cancleOrder', (e) => {
   
  

    var table = document.getElementById("orderList");
   
  

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
                if(parseInt(cells[0].innerHTML, 10) < e.o.id){
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
var html = '<a class=\"btn btn-app\" target=\"_blank\" href=\"/order/detailCancle/show/'+e.o.id+'\" data-id=\"'+e.o.id+'\" onclick=\"checked(this)\">'+'<i class=\"fas fa-edit\"></i> Chi tiết'+'<span class=\"badge bg-danger\" id=\"new_'+e.o.id+'\">Mới</span>'
      +'</a>';
cell8.innerHTML = html;



   
  })
  
  </script>

@endpush