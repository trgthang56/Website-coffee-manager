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
    <h3 class="card-title">Các đơn hàng chưa thanh toán</h3>
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
    <td ><a class="btn btn-app" href="/pay/detail/show/{{ $item->id }}" data-id="{{$item->id}}" onclick="checked(this)">
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
  {{-- <script type="module">
 
    Echo.private('payChannel')
     .listen('payOrder', (e) => {
     
      
    if({{$users->id}} != +e.user_id){
      Swal.fire({
                    title: "Đã thanh toán thành công",
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonText: "In đơn hàng",
                    cancelButtonText: "Không in đơn"
                    }).then((result) => {
                         /* Read more about isConfirmed, isDenied below */
                     if (result.isConfirmed) {
                      $.ajax({
                          headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                            url: '/pay/revenue/exportPdf/',
                            method: 'POST',
                            data:{datePick:datePick},
                            success:function(data){
                          
                          
                            }
                      
                        });
                              

                    }else{
                       count = parseInt(document.getElementById('cart-count').innerText);
                       document.getElementById('cart-count').innerText = count + parseInt(qty);
                    }
                    
                        });
    }
 
   
  })
  
  </script> --}}
@endpush