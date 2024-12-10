@extends('admin.main')
@section('head')

@endsection

@section('content')

  
    <!-- form start -->
    <form   method="POST" action="/editStore/{{$user->id}}" >

        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="exampleInputEmail1">Họ tên</label>
                <input type="text" class="form-control" name="name" value="{{$user->name}}" placeholder="Họ tên" required>
              </div>
            
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="text" class="form-control" name="email" value="{{$user->email}}" placeholder="Email" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label >Ngày tháng năm sinh</label>
                <input type="date" class="form-control" value="{{$user->date_of_birth}}"  name="birth" required>
              </div> 
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label >Số điện thoại</label>
                <input type="text" class="form-control" value="{{$user->phone_number}}"  id="phoneNumber" name="phone" placeholder="SĐT" onchange="validatePhoneNumber()" required>
              </div>
            </div>
           
          </div>
          
       
        
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Vị trí</label>
                  <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" name="role" tabindex="-1" aria-hidden="true">
                      
                    <option selected="selected" data-select2-id="3">Chạy bàn</option>
                      @if($users->role == 0)
                      <option>Quản lý</option>
                      @endIf
                      <option>Thu ngân</option>
                      <option>Pha chế</option>                                                 
                      </select>
                </div> 
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="salary">Lương theo giờ</label>
                  <input type="number" class="form-control" name="salary" value="{{$user->salary}}"  placeholder="Lương" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label >Địa chỉ</label>
                  <input type="text" class="form-control" name="address" value="{{$user->address}}"  placeholder="Địa chỉ" required>
                </div>
              </div>
            </div>
      @csrf
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
        </div>
      </form>

  <!-- /.card -->
@endsection
@section('footer')
<script>
     function validatePhoneNumber() {
            var phoneNumber = document.getElementById('phoneNumber').value;
            // Xoá các ký tự không phải là số
            phoneNumber = phoneNumber.replace(/\D/g, '');

            if (phoneNumber.length != 10) {
                alert('Số điện thoại không hợp lệ');
            } 
        }
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif
@endsection