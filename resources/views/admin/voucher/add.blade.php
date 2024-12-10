

@extends('admin.main')
@section('head')

@endsection

@section('content')
<div class="card-primary">
   
<!-- /.card-header -->
<!-- form start -->
<form  method="POST" action="" enctype="multipart/form-data">
<div class="card-body">
<div class="form-group">
<label for="exampleInputEmail1">Số tiền giảm giá: </label>
<input type="number" class="form-control" placeholder="Nhập số tiền" name="value" required>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Áp dụng cho đơn giá từ: </label>
    <input type="number" class="form-control" placeholder="Nhập số tiền" name="condition" required>
    </div>
<div class="form-group">
<label for="exampleInputEmail1">Đối tượng sử dụng: </label>
<select name="user" class="custom-select form-control-border" id="exampleSelectBorder" >                  
    <option selected='selected' >Tất cả người dùng</option>
    <option >Khách hàng tiềm năng</option>    
    <option >Khách hàng vip</option>    
    <option >Nhân viên cửa hàng</option> 
</select>
</div>
<div class="form-group" >
    <label>Ngày hết hạn: </label><bR>
    <input type="date" name="expiry_date" value="<?php echo date('Y-m-d'); ?>" min="{{ date('Y-m-d') }}"  style="margin-left: 1%">
@csrf
</div>
<div class="form-group" style="margin-top: 3%;">
    <label>Ảnh voucher: </label>
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="avartarFile" name="image"
        onchange="displayImage(this)"  required>
      <label class="custom-file-label" for="avartarFile">Chọn file ảnh</label>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <img id="selectedImage" class="img-fluid" style="display: none;width: 100px;height: 100px;" alt="Selected Image"
        onclick="openModal()">
    </div>
  </div>
<button type="submit" class="btn btn-primary" style="margin-top: 5px">Tạo voucher</button>

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
  }
  

  </script>
@endsection



