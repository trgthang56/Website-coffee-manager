

@extends('admin.main')
@section('head')

@endsection

@section('content')
<div class="card-primary">
   
<!-- /.card-header -->
<!-- form start -->
<form  method="POST" action="" >
<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label >Tên nhân viên</label>
            <input type="text" class="form-control"  value="{{$att->user->name}}" name="name"  readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label >Ngày chấm công</label>
                <input type="text" class="form-control" value="{{$att->work_date}}" name="work_date"  readonly>
                </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label >Giờ vào</label>
            <input type="time" class="form-control" id="start_time" value="{{$att->check_in_time}}"  onchange="validateTime()" name="checkin" required>
            </div>
    </div>
    <div class="col-md-6">

        <div class="form-group">
            <label >Giờ ra</label>
            <input type="time" class="form-control" id="end_time" value="{{$att->check_out_time}}"  onchange="validateTime()" name="checkout"  step="1" required>
            </div>
    </div>
</div>


</div>
<div class="card-footer">
    @csrf
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

<script>
    function validateTime() {
      var startTime = document.getElementById("start_time").value;
      var endTime = document.getElementById("end_time").value;
  
      if (startTime >= endTime) {
        alert("Giờ bắt đầu phải nhỏ hơn giờ kết thúc!");
        document.getElementById("start_time").value = "";
      }
    }
  </script>
@endsection



