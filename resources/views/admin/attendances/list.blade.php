@extends('admin.main')
@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

@endsection
@section('tools')

<form action="/attendance/searchRangeShow/{{$user->id}}" method="POST" >

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
          <th>Ngày chấm công</th>
          <th>Giờ vào</th>
          <th>Giờ ra</th>
          <th>Số giờ làm</th>
       
        </tr>
        </thead>
        <tbody>
            <?php $count=0; ?>
          @foreach ($attendances as $item)

          <tr>
            <td>{{$item->work_date}}</td> 
            <td>{{$item->check_in_time}}</td> 
            <td>{{$item->check_out_time}}</td>      
            <td>{{$item->total_hours}} giờ</td>         
            <?php $count+= $item->total_hours; ?>
  
          </tr>
          @endforeach
        <tr>
        <td></td>
        <td></td>
        <td> <strong>Tổng giờ làm :</strong></td>
        <td> <?php echo $count; ?> &nbsp;giờ</td>    
        </tr>  
        
        </tbody>
       
           
               
            
  
      </table>
      
      
    </div>
    <div class="row">
        <div class="col-md-2">
            <form action="/attendance/exportPdf/" method="POST">
               <input type="hidden" name="user_id" value="{{$user->id}}">
               <input type="hidden" name="attendances" value="{{$attendances}}">
                <button type="submit" class="btn btn-block btn-success btn-xs"   name="redirect"><i class="fas fa-print"></i> &nbsp;&nbsp;In bảng lương</button>
                @csrf
              </form>
        </div>
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