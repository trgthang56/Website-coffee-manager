@extends('admin.main')
@section('head')

@endsection
@section('tools')
<a class="btn  btn-success btn-sm" href="/attendance/confirmAll/" title="Xác nhận"   onclick="return confirm('Bạn xác nhận chấm công tất cả nhân viên ')" >Xác nhận tất cả</a>
@endsection
@section('content')

   <div class="card-body table-responsive p-0" style="max-height: 700px">
    <table id="example2"  class="table table-hover text-nowrap">
        <thead>
        <tr>
          <th>Tên nhân viên</th>    
          <th>Ngày chấm công</th>
          <th>Giờ vào</th>
          <th>Giờ ra</th>
          <th>Số giờ làm</th>
          <th>Trạng thái</th>  
          <th style="width: 100px">&nbsp;Chức năng</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($attendances as $item)
          <tr>
            <td>{{$item->user->name}}</td>
            <td>{{$item->work_date}}</td> 
            <td>{{$item->check_in_time}}</td> 
            <td>{{$item->check_out_time}}</td>      
            <td>{{$item->total_hours}} giờ</td>         
            <td>{{$item->status}}</td> 
            <td>
              <form method="Post" action="/attendance/destroy/{{$item->id}}">
              <a class=" btn btn-primary btn-sm" href="/attendance/edit/{{$item->id}}"
                
                >
                <i class="fas fa-edit"></i>
                </a>
               
                <button class=" btn btn-danger btn-sm" type="submit"
                onclick="return confirm('Bạn muốn xóa chấm công nhân viên {{$item->user->name}}')"
                >
                <i class="fas fa-trash-alt"></i>
                </button>

                <a class="btn  btn-success btn-sm" href="/attendance/confirm/{{ $item->id }}" title="Xác nhận"   onclick="return confirm('Bạn xác nhận chấm công nhân viên {{$item->user->name}}')" >
                <i class="fas fa-check-square"></i>
                  </a>
                @method('DELETE')
                @csrf
              </form>
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


@endsection