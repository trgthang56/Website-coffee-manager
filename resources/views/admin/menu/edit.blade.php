@extends('admin.main')
@section('head')
<script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<div class="card card-primary">
  
    <!-- form start -->
    <form action=" " method="POST">
      <div class="card-body">

        <div class="form-group">
          <label for="menu"> Tên Danh Mục</label>
          <input type="text" name='name' value="{{$menu->name}}" class="form-control"  placeholder="Nhập tên danh mục">
        </div>

        <div class="form-group">
            <label > Danh Mục </label>
            <select name="parent_id" class="custom-select form-control-border" id="exampleSelectBorder" >
                <option value="0"  {{$menu->parent_id == 0 ?'selected':''}}>Danh Mục Cha</option>
                @foreach ($menus as $item)
                <option value="{{$item->id}}"
                    
                    {{$menu->parent_id == $item->id ?'selected':''}}>
                    {{$item->name}}</option>
                @endforeach
        
            </select>
          </div>
          
          <div class="form-group">
            <label > Mô Tả</label>
            <textarea name="description" class="form-control">{{$menu->description}}</textarea>
          </div>
       
          <div class="form-group">
            <label > Mô Tả Chi Tiết</label>
            <textarea name="content" id="content"  class="form-control">{{$menu->content}}</textarea>
          </div>

          <div class="form-group">
            <label>Kích Hoạt</label>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" value="1" type="radio" id="active"
                       name="active" {{ $menu->active == 1 ? 'checked=""' : '' }}>
                <label for="active" class="custom-control-label">Có</label>
            </div>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" value="0" type="radio" id="no_active"
                       name="active" {{ $menu->active == 0 ? 'checked=""' : '' }}>
                <label for="no_active" class="custom-control-label">Không</label>
            </div>
        </div>

        
      <!-- /.card-body -->
          
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Cập nhật danh mục<!--  --></button>
      </div>
      @csrf
    </form>
  </div>
  <!-- /.card -->
@endsection
@section('footer')
<script>
    CKEDITOR.replace('content');
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif
@endsection