

@extends('admin.main')
@section('head')

@endsection

@section('content')
<div class="card card-primary">
   
<!-- /.card-header -->
<!-- form start -->
<form  method="POST" action="" >
<div class="card-body">
<div class="form-group">
<label >Tên </label>
<input type="text" class="form-control" value="{{$tables->name}}" name="name" placeholder="Tên bàn" required>
</div>
<div class="form-group">
<label > Vị trí</label>
<select name="location" class="custom-select form-control-border" id="exampleSelectBorder" >                  
    <option selected='selected' >Trong nhà</option>
    <option >Sân trước</option>  
    <option >Vườn sỏi</option>    
</select>
</div>
@csrf
</div>
<div class="card-footer">
<button type="submit" class="btn btn-primary">Cập nhật thông tin bàn</button>
</div>
</form>
</div>


  

@endsection

@section('footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif


@endsection



