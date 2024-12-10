@extends('admin.main')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite('resources/js/app.js')
<link rel="stylesheet" href="/template/admin//plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet"  type="text/css" href="/template/admin/order/css/sweet.css" />
<style>
 .overlay1 {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Màu nền mờ đen với độ trong suốt 50% */
    z-index: 999;
}

.popup-card {
    display: none;
    position: fixed;
    top: 53%;
    left: 50%;
    border-radius: 3%;
    transform: translate(-50%, -50%);
    background-color: gainsboro;
    padding: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    max-width: 80%;
    max-height: 80%;
    width: 400px;
    height: 700px;
    overflow-y: auto; 

}

.card-content {
  align-items: center;
    justify-content: center;
   
}

.close-btn {
    position: absolute;
    right: 20px;
    font-size: 30px;
    cursor: pointer;
    z-index: 1;
}
.item-popup{
  max-width: 80%;
}
.item-popup:hover{
  border: 1px solid black;;
}
/* Responsive styles */
@media (max-width: 768px) {
    .popup-card {
        max-width: 70%;
    }
    .item-popup img{
      max-width: 80%;
    }
  
}
@media (max-width: 1024px) {
    .popup-card {
        max-width: 100%;
    }
    .item-popup img{
      max-width: 100%;
    }
   
}

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
    <div class="card">
    <div class="card-header">
    <h3 class="card-title">Chi tiết đơn hàng: <strong>{{$order->id}}</strong>&nbsp; Bàn: <strong>{{$order->table->name}}</strong></h3>
 
    </div>
    </div>
   

    <div class="card-body table-responsive p-0" >
      <table class="table table-hover text-nowrap" id="listDetail">
        <thead>
        <tr>
        <th style="text-align: center">STT</th>
        <th>Tên món</th>
        <th style="text-align: center">Số lượng</th>
        <th >Ghi chú món</th>     
        <th>Trạng thái</th>
        <th>Thời gian gọi món</th>
        <th>Giá tiền</th>
        {{-- <th style="text-align: center" >Chức năng</th> --}}
        </tr>
        </thead>
        <tbody>
          
            @foreach ($details as $key => $item)
        <tr >
        <td style="width: 2%;text-align: center"  class="sttDetail">{{ $key + 1 + ($details->currentPage() - 1) * $details->perPage() }}</td>
        <td style="width: 10%;">{{$item->name}}</td>
        <td style="text-align: center" ><input  type="number" min="1" max="99" id="qty_{{$item->id}}"  data-idDetail="{{$item->id}}" value="{{$item->qty}}"  readonly> </td>
        <td style="width: 25%;" >@if(empty($item->mess))<input id="mess_{{$item->id}}" type="text" class="form-control form-control-border"  data-idDetail="{{$item->id}}" value="Không có ghi chú"  readonly>  @else <input id="mess_{{$item->id}}" type="text" class="form-control form-control-border" id="mess-{{$item->id}}" data-idDetail="{{$item->id}}" value="{{$item->mess}}"  readonly> @endIF</td> 
        <td>{{$item->status}}</td>
        <td>{{$item->created_at}}</td>
        <td id="price_{{$item->id}}">
            <?php   $formattedNumber1 = number_format($item->price);echo $formattedNumber1; ?> 
          &nbsp;đ</td>
    {{-- <td style="text-align: center;"> <input type="checkbox"  name="tachDon" data-stt="{{ $key + 1 + ($details->currentPage() - 1) * $details->perPage() }}" value="{{$item->id}}"></td> --}}
        </tr>
  
        @endforeach
        <form >
        <tr> <td style="width: 2%;text-align: center"></td>
            <td> 
              <div style="margin-top: 1%;font-size: 0.7rem;" >
                {{$details->appends(request()->all())->links()}}
             
              </div>
               
             </td>
              
           <td></td>        
            <td></td>
           <td></td>
            <td style="font-size: 1rem;">Tổng tiền : </td>
            <td><strong id="total"><?php
               $formattedNumber = number_format($total);echo $formattedNumber; ?>&nbsp;đ</strong>
           </td>
            {{-- <td  style="text-align: center">  

                <button type="button" class="btn btn-success swalDefaultSuccess"  onclick="traDo()">
                  Tách hóa đơn
                  </button>
               </td> --}}
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td><button type="button" class="btn btn-success swalDefaultSuccess"   id="openPopupBtn">
            Thanh toán 
            </button></td>
          
        </tr>
        @csrf
    </form>
        </tbody>
        </table>
    
       
  </div>
    </div>
   </div>


    <div class="overlay1" id="overlay1"></div>

    <div class="popup-card" id="popupCard">
        <div class="card-content" >
            <span class="close-btn" id="closePopupBtn">&times;</span>
        
              <div class="card">
              <div class="card-header">
              <h2 class="card-title" ><strong>Hóa đơn thanh toán</strong></h2><br>
                <p>
                  Số hóa đơn: <strong>{{$order->id}}</strong>     <span class="float-right">Khu vực: <strong>{{$order->table->location}}</strong></span><br>
                  Người lên đơn: <strong>{{$order->user->name}}</strong> <br>          
                  Ngày tạo đơn: <strong>{{$order->created_at}}</strong><br>
                  Tại bàn: <strong>{{$order->table->name}}</strong>
                </p>
              </div>
              
              <div class="card-body table-responsive p-0" style="max-height: 200px;" >
              <table class="table table-head-fixed text-nowrap">
              <thead>
              <tr>
              <th>Stt</th>
              <th>Tên món</th>
              <th>SL</th>
              <th>ĐG</th>
              <th>T Tiền</th>
              </tr>
              </thead>
              <tbody>
                @foreach($detailAll as $key => $val)
                
              <tr>
              <td>{{$key + 1}}</td>
              <td>{{$val->name}}</td>
              <td>{{$val->qty}}</td>
              <td>
                <?php   $formattedNumber1 = number_format($val->product->price);echo $formattedNumber1; ?> 
              </td>
              <td>
                <?php   $formattedNumber1 = number_format($val->price);echo $formattedNumber1; ?> 
       
              </td>
              </tr>
              @endforeach
             
              
              </tbody>
           <tfoot> 
            <tr><th></th>
            <th ></th>
            <th></th>
            <th></th>
            <th></td>
            </tr>
          </tfoot>
              
              </table>
             
              </div>
              <form action="/pay/payment/" method="POST">
                @csrf
            
              <div class="card-footer clearfix">
                <p>Tổng tiền: &nbsp; <strong><?php   $formattedNumber1 = number_format($total);echo $formattedNumber1; ?> 
                </strong>
               <span class="float-right">Thành tiền:  &nbsp;<strong id="total1" > <?php   $formattedNumber1 = number_format($total);echo $formattedNumber1; ?> 
                </strong></span></p>
                {{-- <p>Mã voucher:  <Br>Giá trị voucher: &nbsp; <strong id="total1" >0 đ</strong> </p> --}}
                <div class="form-group">
                  <label>Tiền chiết khấu (nếu có)</label>
                  <input type="number" class="form-control" min="0" name="sale" value="0" id="sale" placeholder="Chiết khấu" onchange="saleCheck(this)" >
                  </div>
                 
                  {{-- <div class="input-group mb-3">
                    <input type="text" class="form-control"  name="voucher"  id="voucher" placeholder="Mã voucher (nếu có)" onchange="voucherCheck(this)">
                    <div class="input-group-append" >
                      <span class="input-group-text" ><i class="fas fa-check"></i></span>
                      </div>
                    </div> --}}
                    {{-- <div class="input-group mb-3">
                      <input type="text" class="form-control">
                     
                      </div> --}}
                  <div class="form-group">
                    <label>Chọn phương thức thanh toán</label>
                    <select class="form-control" id="payBy" name="method">
                    <option class="item-popup" value="1">VN PAY</option>              
                    <option  class="item-popup" value="3" selected>TIỀN MẶT</option>
                    
                    </select>
                    </div>
                    <input type="hidden" name="id" value="{{$order->id}}">
                    <input type="hidden" name="total" value="{{$total}}">
                    <input type="hidden" id="giaVoucher" value="0">
                    <input type="hidden" class="form-control"  name="voucher" id="voucherCode" >
                    <div class="form-group">
                      <button type="button" class="btn btn-block btn-info btn-sm" id="openSecondPopupBtn" onclick="">Chọn mã voucher (nếu có)</button>
                      </div>
                  <button type="submit" class="btn btn-block btn-success btn-sm"   name="redirect">Thanh toán</button>
                
                  
                  </div>
                </form>
              </div>
              </div>
            

              {{-- đóng bảng --}}
        </div>
 
    
    <div class="popup-card" id="secondPopupCard">
        <div class="card-content">
            <span class="close-btn" id="closeSecondPopupBtn">&times;</span>
            <strong style="font-size: 1.3rem">Nhập mã voucher</strong><br>
            <button id="goBackBtn" class="btn btn-block btn-secondary btn-sm" style="width: 50%;">Quay lại</button><br>
           <form>
           
            <div class="input-group mb-3">
              <input type="text" class="form-control"  id="voucher" placeholder="Mã voucher" >
              
              </div>
              <div class="form-group">
                      {{-- <button type="button" class="btn btn-block btn-success btn-sm"  onclick="">Kiểm tra</button> --}}
                      <button type="button" class="btn btn-block btn-primary btn-sm"   onclick="voucherCheck()" >Áp dụng</button>
              </div>
            </form>
            <div class="callout callout-danger" style="display: none" id="statusVoucherError">
              </div>
              <div class="callout callout-success" style="display: none" id="statusVoucherSuccess">
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
<script type="module">
   
  Echo.private('finishDetails')
      .listen('finishDetail', (e) => {
      
    var x = document.getElementById('myAudio1');
      x.autoplay = true;
     x.load;
    if({{$order->id}} == e.o.id ){
        setTimeout(function() {
        location.reload();
       }, 2000);
        
      }
    
 
  })
   </script>
<script type="module">
 
  Echo.private('finishAllDetails')
   .listen('finishAllDetail', (e) => {
   
    var x = document.getElementById('myAudio1');
      x.autoplay = true;
      x.load();
   if({{$order->id}} == e.o.id){

    setTimeout(function() {
        location.reload();
       }, 2000);
        
       
  
   }
  

 
})

</script>

@endsection
@push('scripts')
 

<script>

function saleCheck(e){
  var sale = parseInt(e.value);
  var price = document.getElementById('total1');
  var total = parseInt({{$total}});
  var voucher = document.getElementById('giaVoucher');
  var thanhTien = total - parseInt(voucher.value);
  if(sale > thanhTien){
    alert('Tiền chiết khấu không thể lớn hơn thành tiền');
    e.value  = 0;
    price.innerHTML  = thanhTien.toLocaleString();
  }else{
     var res = thanhTien - sale;
    price.innerHTML  = res.toLocaleString();
  }
}

function voucherCheck(){

  var code = document.getElementById('voucher').value;
 var total = parseInt({{$total}});

 $.ajax({
              headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/voucher/check/',
                method: 'POST',
                data:{code:code,total:total},
                success:function(data){
                 if(data.error == true){
               var e =  document.getElementById('statusVoucherError');
               var e1 =  document.getElementById('statusVoucherSuccess');
                e.innerHTML = `<h5>`+ data.status +  `!</h5>`;
                e.style.display ="block" ;
                e1.style.display = "none";
                 }else{
                  var e1 =  document.getElementById('statusVoucherError');
                 var e =  document.getElementById('statusVoucherSuccess');
                 var formattedNumber1 = parseInt(data.voucher.value).toLocaleString();
                 var formattedNumber2 = parseInt(data.voucher.condition).toLocaleString();
                  e.innerHTML = `<h5> ${data.status} !</h5>`+`<p>Mã voucher: ${data.voucher.code} <br> Giá trị: ${formattedNumber1}đ <br>Ngày hết hạn: ${data.voucher.expiry_date}<br>Áp dụng cho đơn từ: ${formattedNumber2}đ </p>`;
                  e.style.display = "block";
                  e1.style.display = "none";
                  var voucher =  document.getElementById('voucherCode');
                  voucher.value = data.voucher.code;
                  var giaVoucher = document.getElementById('giaVoucher');
                  giaVoucher.value = data.voucher.value;
                  var price = document.getElementById('total1');
                  var sale =  parseInt(document.getElementById('sale').value);
                  price.innerHTML = (total - sale - data.voucher.value).toLocaleString();
                 }
                    
                },
                error: function (error) {
                    alert("Thêm voucher thất bại");
            }
            });
           
}

document.addEventListener('DOMContentLoaded', function () {
    var openPopupBtn = document.getElementById('openPopupBtn');
    var closePopupBtn = document.getElementById('closePopupBtn');
    var openSecondPopupBtn = document.getElementById('openSecondPopupBtn');
    var closeSecondPopupBtn = document.getElementById('closeSecondPopupBtn');
    var goBackBtn = document.getElementById('goBackBtn');
    var popupCard = document.getElementById('popupCard');
    var secondPopupCard = document.getElementById('secondPopupCard');
    var overlay = document.getElementById('overlay1');

    openPopupBtn.addEventListener('click', function () {
        popupCard.style.display = 'block';
        overlay.style.display = 'block';
    });

    closePopupBtn.addEventListener('click', function () {
        popupCard.style.display = 'none';
        overlay.style.display = 'none';
    });

    openSecondPopupBtn.addEventListener('click', function () {
        secondPopupCard.style.display = 'block';
        popupCard.style.display = 'none';
    });

    closeSecondPopupBtn.addEventListener('click', function () {
        secondPopupCard.style.display = 'none';
        overlay.style.display = 'none';
    });

    goBackBtn.addEventListener('click', function () {
        secondPopupCard.style.display = 'none';
        popupCard.style.display = 'block';
    });
});
</script>



@endpush