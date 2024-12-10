

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
  <h2><strong>Bảng công nhân viên {{$user->name}}</strong></h2>
<table >
<thead>
<tr>
    <th>Ngày chấm công</th>
    <th>Giờ vào</th>
    <th>Giờ ra</th>
    <th>Số giờ làm</th>
</tr>
</thead>
<tbody>
    <?php $count = 0; ?>
    @foreach ($attendances as $item)
    <tr>
      <td>{{$item->work_date}}</td> 
      <td>{{$item->check_in_time}}</td> 
      <td>{{$item->check_out_time}}</td>      
      <td>{{$item->total_hours}} giờ</td>         
      <?php $count+= $item->total_hours; ?>
  
    </tr>
    @endforeach
    
   
  </tbody>
</table>
 Tổng giờ: &nbsp; <strong> <?php echo $count; ?> &nbsp;giờ

</body>
</html>
   
  
  

    
 
          
            
           
   
       
