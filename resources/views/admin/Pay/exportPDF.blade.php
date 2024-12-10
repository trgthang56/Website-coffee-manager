

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <style>
    body {
        font-family: 'DejaVu Sans';
        }
        table, th, td {
  border:1px solid rgb(30, 4, 4);
}
    </style>
</head>
<body>
  <h2><strong>Hóa đơn thanh toán</strong></h2>
  <p>
    Số hóa đơn: <strong>{{$order->id}}</strong>    &nbsp;  <span >Khu vực: <strong>{{$order->table->location}}</strong></span><br>
    Người lên đơn: <strong>{{$order->user->name}}</strong>   <br>          
    Ngày tạo đơn: <strong>{{$order->created_at}}</strong><br>
    Tại bàn: <strong>{{$order->table->name}} </strong>&nbsp;  @if($order->code != null)<span >Mã voucher: <strong>{{$order->voucher->code}}</strong></span>@endif
  </p>


<table >
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
</table>
  <p>Tổng tiền: &nbsp; <strong><?php   $formattedNumber1 = number_format($order->price);echo $formattedNumber1; ?> 
  </strong>&nbsp;đ<br>
  Chiết khấu: &nbsp; <strong><?php   $formattedNumber1 = number_format($order->price - $order->total);echo $formattedNumber1; ?> 
  </strong>&nbsp;đ<br>
 <span >Thành tiền:  &nbsp;<strong > <?php   $formattedNumber1 = number_format($order->total);echo $formattedNumber1; ?> 
  </strong>&nbsp;đ</span></p>  
</body>
</html>
   
  
  

    
 
          
            
           
   
       
