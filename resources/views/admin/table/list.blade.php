@extends('admin.main')
@section('head')

@endsection

@section('content')

 
    <!-- /.card-header -->

      <table id="example2" class="table table-bordered table-hover">
        <thead>
        <tr>
          <th>Mã bàn</th>
          <th>Tên bàn</th>
          <th>Vị trí</th>        
          <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($tables as $item)
          <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->location}}</td>         
            <td>
              <form method="Post" action="/tables/destroy/{{$item->id}}">
              <a class=" btn btn-primary btn-sm" href="/tables/edit/{{$item->id}}"
                
                >
                <i class="fas fa-edit"></i>
                </a>
               
                <button class=" btn btn-danger btn-sm" type="submit"
                onclick="return confirm('Bạn chắc chắn muốn xóa bàn {{$item->name}}')"
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
      <div style="margin-top: 1%;margin-left: 2%;">
        {{$tables->appends(request()->all())->links()}}
      </div>
     
     <a href="/tables/add/" style="margin-left: 1%">
      <button type="button" style="margin-top: 5px" class="btn btn-success swalDefaultSuccess"  >
        Thêm bàn
        </button>
      </a>
  
    <!-- /.card-body -->

  
  

@endsection

@section('footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif


@endsection