@extends('admin.main')
@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

@endsection
@section('tools')

<form action="/attendance/searchRange/" method="POST" >

        <div class="row">
            {{-- <label  for="start_date">Từ ngày:</label>
            <input type="date" id="start_date" name="daystart"  max="" required> --}}
            {{-- <label for="date_range">Chọn khoảng ngày:</label>&nbsp;&nbsp; --}}
            <input type="text" id="date_range" name="date_range" required>
       
        {{-- <div class="col-4">
            <label   for="end_date">Đến ngày:</label>
            <input type="date" id="end_date" name="dayend"   max="" required>
        </div> --}}
      
        
                 <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
                </button>
               
        </div>
    
 
    @csrf
     </form>
       
@endsection
@section('content')

<div class="card-body table-responsive p-0" style="max-height: 700px">
    <table id="example2"  class="table table-hover text-nowrap">
        <thead>
        <tr>
          <th>Tên nhân viên</th>    
          <th>Chức vụ</th>    
          <th>Số giờ làm</th>      
          <th>Số đơn tạo</th>  
          <th>Lương dự tính</th>   
          <th>Chức năng</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($listUser as $item)
          <tr>
            <td>{{$item->name}}</td>
            <td><?php if ($item->role == 2) {
                echo'Nhân viên thu ngân';
                }
                elseif ($item->role == 3) {
                echo'Nhân viên pha chế';
                }
                elseif ($item->role == 4) {
                echo'Nhân viên chạy bàn';
                }
            ?></td>
            <td><?php  $count = 0;
            foreach($attendances as $val){
                if($val->user_id == $item->id){
                    $count+= $val->total_hours;
                }
            } echo $count;   ?>  &nbsp;h</td> 
          
        <td><?php  $count1 = 0;
            foreach($order as $val){
                if($val->user_id == $item->id){
                    $count1++;
                }
            } echo $count1;   ?></td>   
              <td><?php $salary = $count* $item->salary;  $formattedNumber1 = number_format($salary);echo $formattedNumber1; ?> 
                &nbsp;đ</td>  
          
                <td ><a class="btn btn-block btn-info btn-sm" href="/attendance/show/{{ $item->id }}" >
                    <i class="fas fa-edit"></i> Chi tiết      
                    </a>     
            </td>       
       
  
          </tr>
          @endforeach
          
         
        </tbody>
        
      </table>
    
    </div>
 

  
  

@endsection

@section('footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif
<script>
      var start_date =   @json($start_date);
    var end_date = @json($end_date);
flatpickr("#date_range", {
    mode: "range",  // Chế độ chọn range date
    dateFormat: "d/m/Y",  // Định dạng ngày dd/mm/yyyy
    locale: {
        weekdays: {
            shorthand: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            longhand: [
                "Chủ Nhật",
                "Thứ Hai",
                "Thứ Ba",
                "Thứ Tư",
                "Thứ Năm",
                "Thứ Sáu",
                "Thứ Bảy"
            ]
        },
        months: {
            shorthand: [
                "Th 1",
                "Th 2",
                "Th 3",
                "Th 4",
                "Th 5",
                "Th 6",
                "Th 7",
                "Th 8",
                "Th 9",
                "Th 10",
                "Th 11",
                "Th 12"
            ],
            longhand: [
                "Tháng Một",
                "Tháng Hai",
                "Tháng Ba",
                "Tháng Tư",
                "Tháng Năm",
                "Tháng Sáu",
                "Tháng Bảy",
                "Tháng Tám",
                "Tháng Chín",
                "Tháng Mười",
                "Tháng Mười Một",
                "Tháng Mười Hai"
            ]
        },
        rangeSeparator: " - " 
    },
    defaultDate: [start_date, end_date],
    maxDate: "today"
  
});
</script>

@endsection