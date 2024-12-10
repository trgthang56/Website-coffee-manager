@extends('admin.main')
@section('head')

@endsection

@section('content')
<table class="table ">
    <thead>
        <tr>
            <th style="width: 50px;">ID</th>
            <th>Tên Đồ Uống</th>
            <th>Danh Mục</th>
            <th>Giá Gốc</th>
            <th>Giá Khuyễn Mãi</th>
            <th>Trạng thái kích hoạt</th>
            <th>Thời gian cập nhật</th>
            <th style="width: 100px;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
     @foreach ($product as $item)
         <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->menu->name}}</td>
            <td>{{$item->price}}</td>
            <td>{{$item->price_sale}}</td>
            <td>{!! \App\Helpers\Helper::active($item->active) !!}</td>
            <td>{{$item->updated_at}}</td>
            <td>
                <a class="btn btn-primary btn-sm" href="/product/edit/{{ $item->id }}">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="/product/destroy/{{ $item->id }}" class="btn btn-danger btn-sm"
                onclick="return confirm('Bạn chắc chắn muốn xóa đồ uống {{$item->name}}')">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
         </tr>
     @endforeach
    </tbody>
</table>
@endsection
@section('footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif
@endsection