@extends('admin.main')
@section('head')

@endsection

@section('content')

   <div class="card-body table-responsive p-0" style="max-height: 700px">
    <table id="example2"  class="table table-hover text-nowrap">
        <thead>
        <tr>
          <th>Mã voucher</th>    
          <th>Giá trị</th>
          <th>Điều kiện</th>
          <th>Ngày hết hạn</th>
          <th>Trạng thái</th>
          <th>Chức vụ</th>
          <th>Tên người dùng</th>
          <th>Ngày tạo voucher</th>          
          <th style="width: 100px">&nbsp;Chức năng</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($vouchers as $item)
          <tr>
            <td>{{$item->code}}</td>
         
            <td>
                <?php   $formattedNumber1 = number_format($item->value);echo $formattedNumber1; ?> 
          &nbsp;đ
            </td>
            <td>
                <?php   $formattedNumber1 = number_format($item->condition);echo $formattedNumber1; ?> 
                &nbsp;đ
            </td>
            <td>{{$item->expiry_date}}</td> 
            <td>{{$item->status}}</td> 
            <td>@if($item->user_role == 5) Khách hàng tiềm năng @elseIf($item->user_role  == 6) Khách hàng vip @else Nhân viên cửa hàng @endif</td>           
            <td>{{$item->user->name}}</td> 
            <td>{{$item->created_at}}</td> 
            <td>
              <form method="Post" action="/voucher/destroy/{{$item->id}}">
              <a class=" btn btn-primary btn-sm" href="/voucher/edit/{{$item->id}}"
                
                >
                <i class="fas fa-edit"></i>
                </a>
               
                <button class=" btn btn-danger btn-sm" type="submit"
                onclick="return confirm('Bạn chắc chắn muốn xóa voucher {{$item->code}}')"
                >
                <i class="fas fa-trash-alt"></i>
                </button>
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