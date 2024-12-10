@extends('admin.main')
@section('head')

@endsection

@section('content')

   <div class="card-body table-responsive p-0" style="max-height: 700px">
    <table id="example2"  class="table table-hover text-nowrap">
        <thead>
        <tr>
          <th>Tên nhân viên</th>    
          <th>Ngày chấm công</th>
          <th>Giờ vào</th>
          <th>Trạng thái</th>  
         
        </tr>
        </thead>
        <tbody>
          @foreach ($attendances as $item)
          <tr>
            <td>{{$item->user->name}}</td>
            <td>{{$item->work_date}}</td> 
            <td>{{$item->check_in_time}}</td> 
         
            <td>{{$item->status}}</td> 
          
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


@endsection