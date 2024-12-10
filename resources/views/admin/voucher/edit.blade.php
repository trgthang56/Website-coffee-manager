

@extends('admin.main')
@section('head')

@endsection

@section('content')
<div class="card card-primary">
   
<!-- /.card-header -->
<!-- form start -->
<form  method="POST" action="" enctype="multipart/form-data">
<div class="card-body">
    <div class="form-group">
        <label >Mã voucher: </label>
        <input type="text" class="form-control" value="{{$voucher->code}}"  readonly>
        </div>
<div class="form-group">
<label >Sửa số tiền giảm giá: </label>
<input type="number" class="form-control" value="{{$voucher->value}}"  name="value" required>
</div>
<div class="form-group">
    <label >Sửa áp dụng cho đơn giá từ: </label>
    <input type="number" class="form-control" value="{{$voucher->condition}}"  name="condition" required>
    </div>
<div class="form-group" >
    <label>Sửa ngày hết hạn: </label><bR>
    <input type="date"  name="expiry_date" value="{{$voucher->expiry_date}}"  style="margin-left: 1%">
@csrf
</div>
<div class="form-group" style="margin-top: 3%;">
    <label>Sửa ảnh voucher: <q>
        không sửa ảnh thì bỏ trống 
    </q></label>
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="avartarFile" name="image"
        onchange="displayImage(this)"  >
      <label class="custom-file-label" for="avartarFile">Chọn file ảnh</label>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <img id="selectedImage" class="img-fluid" style="display: none;" alt="Selected Image"
        onclick="openModal()">
    </div>
  </div>
<button type="submit" class="btn btn-primary" style="margin-top: 5px">Cập nhật voucher</button>

</form>
</div>


  

@endsection

@section('footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script> document.getElementById('avartarFile').addEventListener('change', function (e) {
    var fileName = e.target.files[0].name;
    var label = document.querySelector('.custom-file-label');
    label.innerHTML = fileName;
  });
  function displayImage(input) {
    var selectedImage = document.getElementById('selectedImage');
    if (input.files && input.files[0]) {
      var reader = new FileReader();
  
      reader.onload = function (e) {
        selectedImage.style.display = 'block';
        selectedImage.src = e.target.result;
      };
  
      reader.readAsDataURL(input.files[0]);
    }
  }</script>
@endsection



