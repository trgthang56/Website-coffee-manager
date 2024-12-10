@extends('admin.main')
@section('head')
<script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<div class="card card-primary">
  
    <!-- form start -->
    <form action=" " method="POST"  enctype="multipart/form-data">
      <div class="card-body">
<div class="row">

    <div class="col-md-6">
        <div class="form-group">
          <label for="menu"> Tên Danh Mục</label>
          <input type="text" name='name' value="{{$product->name}}" class="form-control"  placeholder="Nhập tên đồ uống" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label > Danh Mục </label>
            <select name="menu_id" class="custom-select form-control-border" id="exampleSelectBorder" >              
                @foreach ($menus as $item)
                <option value="{{$item->id}}"
                    
                    {{$product->menu_id == $item->id ?'selected':''}}>
                    {{$item->name}}</option>
                @endforeach
        
            </select>
          </div>
     </div>

</div>
          
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="menu">Giá Gốc</label>
            <input type="number" name="price" value="{{ $product->price }}"  class="form-control" required>
        </div>
    </div>
    <div class="col-md-6">

        <div class="form-group">
            <label for="menu">Giá Giảm</label>
            <input type="number" name="price_sale" value="{{ $product->price_sale }}"  class="form-control" >
        </div>
    </div>

</div>
          <div class="form-group">
            <label > Mô Tả</label>
            <textarea name="description" class="form-control">{{$product->description}}</textarea>
          </div>
       
          <div class="form-group">
            <label > Mô Tả Chi Tiết</label>
            <textarea name="content" id="content"  class="form-control">{{$product->content}}</textarea>
          </div>      
          <div class="form-group">
            <label>Kích Hoạt</label>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                    {{ $product->active == 1 ? ' checked=""' : '' }}>
                <label for="active" class="custom-control-label">Có</label>
            </div>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                    {{ $product->active == 0 ? ' checked=""' : '' }}>
                <label for="no_active" class="custom-control-label">Không</label>
            </div>
        </div>

          {{-- <div class="form-group">
            <label> Chọn ảnh đồ uống</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="imagename" name="image">
              <label class="custom-file-label" for="customFile">Chọn ảnh đồ uống</label>                    
              </div>
        </div> --}}
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="avartarFile" name="image"
              onchange="displayImage(this)">
            <label class="custom-file-label" for="avartarFile">Chọn file ảnh</label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <img id="selectedImage" class="img-fluid" style="display: none;" alt="Selected Image"
              onclick="openModal()">
          </div>
        </div>
      <!-- /.card-body -->
          
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Cập nhật thông tin đồ uống<!--  --></button>
      </div>
      @csrf
    </form>
  </div>
  <!-- /.card -->
@endsection
@section('footer')
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
<script>
    CKEDITOR.replace('content');
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif
@endsection