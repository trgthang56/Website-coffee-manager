@extends('admin.main')
@section('head')
<style>
   /* styles.css */
#logTable {
    width: 100%;
    border-collapse: collapse;
    max-height: 600px; /* Đặt chiều cao tối đa của thẻ div */
    overflow-y: auto; /* Tạo thanh cuộn dọc khi nội dung vượt quá chiều cao tối đa */
    background-color:#f2f2f2; 
}

/* Responsive CSS */
@media screen and (max-width: 768px) {
    #logTable {
        font-size: 12px; /* Điều chỉnh kích thước font cho thiết bị có màn hình nhỏ */
        max-height: 100vh; /* Điều chỉnh chiều cao tối đa của bảng khi màn hình nhỏ hơn hoặc bằng 768px */
    }
}
@media screen and (max-width: 820px) {
    #logTable {
        font-size: 12px; /* Điều chỉnh kích thước font cho thiết bị có màn hình nhỏ */
        max-height: 150vh; /* Điều chỉnh chiều cao tối đa của bảng khi màn hình nhỏ hơn hoặc bằng 768px */
    }
}
</style>
@endsection
@section('content')

    {{-- <div class="card-header">
        <h3 class="card-title">Trang log lại hệ thống</h3>
        <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px;">
        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm kiếm">
        <div class="input-group-append">
        <button type="submit" class="btn btn-default">
        <i class="fas fa-search"></i>
        </button>
        </div>
        </div>
        </div>
        </div> --}}

 <!-- Your HTML content goes here -->
 <div class="card-body"  id="logTable">
  
   
    @foreach ($newAll as $item)
        
  
    <div class="post">
    <div class="user-block">
        @if($item->user_id == 0 )
    <img class="img-circle img-bordered-sm" src="/template/admin/dist/img/customer.png" alt="user image">
    @elseIf($item->user->image === null)
    <img class="img-circle img-bordered-sm" src="/template/admin/dist/img/avatar5.png" alt="user image">
    @else <img class="img-circle img-bordered-sm" src="{{$item->user->image}}" alt="user image"> @endIf
    @if($item->user_id == 0)
    <span class="username">
        <a href="#">Khách hàng</a>
        {{-- <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a> --}}
        </span>
        @else
    <span class="username">
    <a href="#">{{$item->user->name}}</a>
    {{-- <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a> --}}
    </span>
    @endIf
    <span class="description">Thời gian - {{$item->created_at}}</span>
    </div>
    
    <p>
    {{$item->content}}
    </p>
    {{-- <p>
    <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
    <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
    <span class="float-right">
    <a href="#" class="link-black text-sm">
    <i class="far fa-comments mr-1"></i> Comments (5)
    </a>
    </span>
    </p> --}}
    {{-- <input class="form-control form-control-sm" type="text" placeholder="Type a comment"> --}}
    </div>

    @endforeach  
   
    


    
   
    
    </div>

@endsection
@section('footer')
<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Fetch log data and populate the logTable

    // Scroll to the bottom after updating the table
    scrollToBottom();
});
function scrollToBottom() {
    const logTable = document.getElementById("logTable");
    logTable.scrollTop = logTable.scrollHeight;
}
</script>
@endsection