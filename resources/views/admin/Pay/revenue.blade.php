@extends('admin.main')
@section('head')

<meta name="csrf-token" content="{{ csrf_token() }}">


</style>
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
    <div class="card" >
       

       
        <div class="card-header ">

        
            <!-- Các nút hoặc nội dung trong card header -->
       
        <form action="/pay/revenue/search/" method="POST" >
        <div class="input-group input-group-sm" >
    <label>Từ ngày:</label>
    <input type="date" id="ngayBatDau" name="daystart" class="date-input" value="{{$daystart}}"  style="margin-left: 1%">

    <label  style="margin-left: 2%">Đến ngày:</label>
    <input type="date" id="ngayKetThuc" name="dayend" class="date-input" value="{{$dayend}}" style="margin-left: 1%">
        
    <div class="input-group-append" style="margin-left: 2%">
        <button type="submit" class="btn btn-default">
        <i class="fas fa-search"></i>
        </button>
        </div>
    </div>
        @csrf
         </form>
           
        </div>
   
    
    </div>
    </div>
   <div class="card-body table-responsive p-0" style="max-height: 500px">
    <table class="table table-hover text-nowrap" id="orderList">
    <thead>
    <tr>
    <th>ID</th>
    <th>Người lên đơn</th>
    <th>Tên bàn</th>
    <th>Nhân viên thanh toán</th>
    <th>Trạng thái đơn</th>
    <th>Thời gian tạo</th>
    <th>Thời gian thanh toán đơn</th>
    <th>Voucher đã dùng</th>
    <th>PTTT</th>
    <th>Chi tiết</th>
    </tr>
    </thead>
    <tbody >
        @foreach ($Orders as $item)
    <tr>
    <td >{{$item->id}}</td>
    <td >{{$item->user->name}}</td>
    <td >{{$item->table->name}} </td>
    <td >{{$item->userPay->name}}</td> 
    <td >{{$item->status}}</td>
    <td >{{$item->created_at}}</td>
    <td id="update-{{$item->id}}">{{$item->updated_at}}</td>
    <td>@if($item->code != null) {{$item->voucher->code}}@else Không sử dụng voucher @endif</td>
    <td >{{$item->payMethod}}</td>
    <td ><a class="btn btn-app" href="/pay/reDetail/show/{{ $item->id }}" data-id="{{$item->id}}" >
        <i class="fas fa-edit"></i> Chi tiết
        <span class="badge bg-danger" id="new_{{$item->id}}"></span>
        </a>
        
       
     
       
    </a>
 
   
</td>
    </tr>
    @endforeach
    </tbody>
    </table>
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>


@endif

@endsection
@push('scripts')
<script>
 
    // flatpickr("#ngayBatDau", {
     
    //     enableTime: false, // Nếu bạn muốn chọn cả giờ và phút, đặt true
    //     dateFormat: "Y-m-d",
    
    //     onChange: function(selectedDates, dateStr, instance) {
    //         // Cập nhật ngày kết thúc khi chọn ngày bắt đầu
    //         flatpickr("#ngayKetThuc", {
    //             enableTime: false,
    //             dateFormat: "Y-m-d",
    //             minDate: dateStr,
               
    //         });
    //     }
    // });
    
    // flatpickr("#ngayKetThuc", {
    //     enableTime: false,
    //     dateFormat: "Y-m-d",
       
    // });
    </script>


 <script type="module">
Echo.private('finishDetails')
    .listen('finishDetail', (e) => {
       
        
   
  
    var x = document.getElementById('myAudio1');
    x.autoplay = true;
    x.load();
    setTimeout(function() {
        location.reload();
       }, 3000);
        
})
</script>


  <script type="module">
  
    
    Echo.private('finishAllDetails')
     .listen('finishAllDetail', (e) => {
        var x = document.getElementById('myAudio1');
      x.autoplay = true;
      x.load();
      setTimeout(function() {
        location.reload();
       }, 3000);
        
            
  
   
  })
  
  </script>
@endpush