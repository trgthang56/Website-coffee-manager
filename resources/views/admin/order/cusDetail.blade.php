@extends('admin.main')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite('resources/js/app.js')
<link rel="stylesheet" href="/template/admin//plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet"  type="text/css" href="/template/admin/order/css/sweet.css" />
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
    <h3 class="card-title">Chi tiết đơn hàng: <strong>{{$order->id}}</strong>&nbsp; Bàn: <strong>{{$order->table->name}}</strong></h3>
    <div class="card-tools">
    
    </div>
    </div>
    </div>
   

    <div class="card-body table-responsive p-0">
      @if($check != 0)

      <table class="table table-hover text-nowrap" id="listDetail">
        <thead>
        <tr>
        <th style="text-align: center">STT</th>
        <th>Tên món</th>
        <th>Số lượng</th>
        <th >Ghi chú món</th>  
        <th>Trạng thái</th>
        <th>Thời gian gọi món</th>
        <th>Giá tiền</th>
        <th style="text-align: center">Chức năng</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($details as $key => $item)
        <tr >
        <td style="width: 2%;text-align: center"  class="sttDetail">{{ $key + 1 + ($details->currentPage() - 1) * $details->perPage() }}</td>
        <td style="width: 10%;">{{$item->name}}</td>
        <td style="width: 2%;text-align: center" ><input  type="number" min="1" max="99" id="qty_{{$item->id}}" style="width: 70%;" data-idDetail="{{$item->id}}" value="{{$item->qty}}" onchange="updateQty(this)"> </td>
        <td style="width: 25%;" >@if(empty($item->mess))<input id="mess_{{$item->id}}" type="text" class="form-control form-control-border"  data-idDetail="{{$item->id}}" value="Không có ghi chú" onchange="updateMess(this)">  @else <input id="mess_{{$item->id}}" type="text" class="form-control form-control-border" id="mess-{{$item->id}}" data-idDetail="{{$item->id}}" value="{{$item->mess}}" onchange="updateMess(this)"> @endIF</td> 
      
        <td>{{$item->status}}</td>
        <td>{{$item->created_at}}</td>
        <td id="price_{{$item->id}}">  <?php   $formattedNumber1 = number_format($item->price);echo $formattedNumber1; ?> &nbsp;đ</td>
        <td style="width: 5%;text-align: center">
           <form>
            <a  class="btn btn-danger btn-sm" data-id="{{$item->id}}"  data-row="{{$key+1}}"
            onclick="deleteDetail(this)">
                <i class="fas fa-trash"></i>
            </a>
            @csrf
           </form>
       
           
    </td>

        </tr>
        @endforeach
        <form >
        <tr>
          <td><button type="button" class="btn btn-block bg-gradient-danger" onclick="deleteAll()">Xóa toàn bộ</button></td>
          
               <td style="width: 2%;text-align: center">@if($doDaTra == 0)<button type="button"  class="btn btn-block bg-gradient-danger" id="cancleButton1"  onclick="huyDon(this)">Hủy đơn</button>@endIF</td>
            <td> <div style="margin-top: 1%;" >
              {{$details->appends(request()->all())->links()}}
            </div></td>         
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td> 
              @if($users->role != 2 && $users->role != 4)
              <button type="button" class="btn btn-success swalDefaultSuccess"  onclick="duyetDon()">
                Duyệt toàn bộ đơn
                </button>
                @endIF
           </td>
           
               
        </tr>
        @csrf
    </form>
        </tbody>
        </table>
    
       
    
          <p style="text-align: center;font-size: 20px" id="textNote"></p>
          <button type="button" style="width: 12%;margin-left: 45%;display: none" class="btn btn-block bg-gradient-danger" onclick="huyDon(this)" id="cancleButton" >Hủy đơn</button>
         
 
  @else
      <p style="text-align: center;font-size: 20px" >Đơn hàng chưa có đồ đặt mới</p>
      @if($doDaTra == 0)<button type="button" style="width: 12%;margin-left: 45%;" class="btn btn-block bg-gradient-danger" onclick="huyDon(this)">Hủy đơn</button>@endIF
    @endif
    
  </div>
    </div>
    
   
       
    </div>
   
    

@endsection
@section('footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif
<script type="text/javascript" src="/template/admin/order/js/sweet-alert.js"></script>
<script>
    function addLeadingZero(number) {
  // Hàm này thêm số 0 ở trước nếu giá trị dưới 10
  return number < 10 ? '0' + number : number;
}    
function huyDon(event){
  if(confirm("Bạn muốn hủy đơn "+{{$order->id}}) == true){
    id={{$order->id}};
    var _token = $('input[name="_token"]').val();
    $.ajax({ 
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
              method: 'POST',
              datatype: 'JSON',
              data: {id:id},
              url: '{{URL::to('/order/cancle/')}}',
              success: function(result){
                 if(result.error == false){
                
                 }else{
                  alert('Lỗi vui lòng thử lại');
                 }
              },error: function(){
                alert('Lỗi vui lòng thử lại');
              }
          
            });
  }
}
function duyetDon(){
  if(confirm("Bạn muốn duyệt toàn bộ đơn "+{{$order->id}}) == true){
    id={{$order->id}};
    var _token = $('input[name="_token"]').val();
    $.ajax({ 
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
              method: 'POST',
              datatype: 'JSON',
              data: {id:id},
              url: '{{URL::to('/confirm/allDetail/')}}',
              success: function(result){
                 if(result.error == false){
                
                 }else{
                  alert('Lỗi vui lòng thử lại');
                 }
              },error: function(){
                alert('Lỗi vui lòng thử lại');
              }
          
            });
  }
}
function deleteDetail(event){
  id = event.getAttribute("data-id");
  stt = event.getAttribute("data-row");
  var _token = $('input[name="_token"]').val();
  if(confirm("Bạn muốn xóa đồ uống thứ "+stt) == true){
    $.ajax({
              method: 'POST',
              datatype: 'JSON',
              data: {id:id,stt:stt,_token:_token},
              url: '{{URL::to('/delete/cusDetail/')}}',
              success: function(result){
                 if(result.error == false){
                
                 }else{
                  alert('Lỗi vui lòng thử lại');
                 }
              },
          
            });
  }
}
function deleteAll(){
  id = {{$order->id}};
  var _token = $('input[name="_token"]').val();
  if(confirm("Bạn muốn xóa tất cả đồ uống ?") == true){
    $.ajax({
              method: 'POST',
              datatype: 'JSON',
              data: {id:id,_token:_token},
              url: '{{URL::to('/deleteAll/cusDetail/')}}',
              success: function(result){
                 if(result.error == false){
                
                 }else{
                  alert('Lỗi vui lòng thử lại');
                 }
              },
          
            });
  }
}
</script>
<script type="text/javascript">
 
  
  function updateQty(event){
      var id = event.getAttribute('data-idDetail');
      var qty = event.value;
      var _token = $('input[name="_token"]').val();
      $.ajax({
                method: 'POST',
                datatype: 'JSON',
                data: {id:id,qty:qty,_token:_token},
                url: '{{URL::to('/update/cusDetail/')}}',
                success: function(result){
                   if(result.error ==false){
                      
                    
                   }else{
                    alert('Lỗi vui lòng thử lại');
                   }
                },
            
              });
  
  }
  function updateMess(event){
      var id = event.getAttribute('data-idDetail');
      var mess = event.value;
      var _token = $('input[name="_token"]').val();
      $.ajax({
                method: 'POST',
                datatype: 'JSON',
                data: {id:id,mess:mess,_token:_token},
                url: '{{URL::to('/update/cusDetail')}}',
                success: function(result){
                   if(result.error ==false){
                  
                      
       
                    
                   }else{
                    alert('Lỗi vui lòng thử lại');
                   }
                },
            
              });
  
  }
  </script>
  <script type="module">
     
     
      Echo.private('CusOrderChannel')
      .listen('cusOrder', (e) => {
        
      if(e.o.id == {{$order->id}}){
        setTimeout(function() {
    // Đoạn mã cần thực hiện sau thời gian trễ
          location.reload();
      }, 3000); 
  
  
      }
    
  })
  
     
  </script>
  
   <script type="module">
   
     Echo.private('updateDetails')
      .listen('updateDetail', (e) => {
    
        var price = document.getElementById("price_"+e.detail.id);
        var qty = document.getElementById("qty_"+e.detail.id);
        var formattedNumber = e.detail.price.toLocaleString()
        price.innerHTML = formattedNumber+"&nbsp;đ";
        qty.value = e.detail.qty;
        if(e.detail.mess != ""){
        var mess = document.getElementById("mess_"+e.detail.id);
        mess.value = e.detail.mess;
        }
        
    
  })
  
   </script>
  
   <script type="module">
   
    Echo.private('deleteDetails')
     .listen('deleteDetail', (e) => {
     
  
       if({{$order->id}} == e.detail.order_id){
          var table = document.getElementById("listDetail");
          table.deleteRow(e.detail.stt);
          var stt = document.getElementsByClassName("sttDetail");
           if(stt.length > 0){
              for(var i=0;i<stt.length;i++){
                  stt[i].innerHTML = i+1;
                    }
           }else{
      // Duyệt qua từng dòng và xóa
            while (table.rows.length > 0) {
                table.deleteRow(0); // Xóa dòng đầu tiên (0) liên tục cho đến khi không còn dòng
            }
  
             var  t = document.getElementById("textNote");
             t.innerHTML = "Đơn hàng chưa có đồ đặt mới";
           
             if(e.detail.status != "Chưa thanh toán"){
            var b = document.getElementById("cancleButton");
            b.style.display = "block";
             }
            
          }
       }
  })
  </script>
  
  <script type="module">
   
    Echo.private('deleteAllDetails')
     .listen('deleteAllDetail', (e) => {
  
     if({{$order->id}} == e.o.id){
       var table = document.getElementById("listDetail");
    
  
      // Duyệt qua từng dòng và xóa
      while (table.rows.length > 0) {
          table.deleteRow(0); // Xóa dòng đầu tiên (0) liên tục cho đến khi không còn dòng
        }
        var  t = document.getElementById("textNote");
     
       t.innerHTML = "Đơn hàng chưa có đồ đặt mới";
       if(e.o.status != "Chưa thanh toán"){
            var b = document.getElementById("cancleButton");
            b.style.display = "block";
             }
     }
    
  
   
  })
  
  </script>
  
  <script type="module">
   
    Echo.private('cancleOrders')
     .listen('cancleOrder', (e) => {
    
     if({{$order->id}} == e.o.id){
      Swal.fire({
  
  title: "Đã hủy đơn "+e.o.id,
  icon: "success",                         
  confirmButtonText: "Đi tới danh sách đơn hàng"                  
  }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  
  window.location.href = "{{url('/order/bill/list')}}";   
  });
    
     }
    
  
   
  })
  
  </script>
  
 
  <script type="module">
   
    Echo.private('confirmAllDetails')
     .listen('confirmAllDetail', (e) => {
     
      var x = document.getElementById('myAudio1');
        x.autoplay = true;
        x.load();
     if({{$order->id}} == e.o.id){
  
      Swal.fire({
  
  title: "Đã duyệt toàn bộ đơn "+e.o.id,
  icon: "success",                         
  confirmButtonText: "Đi tới danh sách đơn hàng"                  
  }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  
  window.location.href = "{{url('/order/bill/list')}}";   
  });
    
     }
    
  
   
  })
  
  </script>
  
@endsection
