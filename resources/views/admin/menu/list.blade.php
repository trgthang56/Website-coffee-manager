@extends('admin.main')
@section('head')

@endsection

@section('content')
<table class="table ">
    <thead>
        <tr>
            <th style="width: 50px;">ID</th>
            <th>Tên thư mục</th>
            <th>Trạng thái kích hoạt</th>
            <th>Thời gian cập nhật</th>
            <th style="width: 100px;">&nbsp;</th>

        </tr>
    </thead>
    <tbody>
        {!!\App\Helpers\Helper::menu($menus) !!}
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