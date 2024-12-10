<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
      <img src="/template/admin/dist/img/logocafe1.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Nhà Duyên</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{$users->image}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{$users->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Tìm kiếm" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class='fas fa-user-circle' style="font-size: 25px" ></i>
              <p style="margin-left: 5px">
                Quản lý tài khoản 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             @if($users->role == 1 || $users->role == 0 )
              <li class="nav-item" >
                <a href="/listAcc/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách tài khoản </p>
                </a>
              </li>
              @endIf
              <li class="nav-item">
                <a href="/profile/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thông tin tài khoản</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/logout/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Đăng xuất</p>
                </a>
              </li>
            </ul>
          </li>
          @if($users->role == 1 || $users->role == 0 )
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class='fas fa-bars' style="font-size: 25px" ></i>
              <p style="margin-left: 5px">
               Quản lý danh mục 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
           
              <li class="nav-item" >
                <a href="/menus/add/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm danh mục</p>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="/menus/list/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách danh mục</p>
                </a>
              </li>
            
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-coffee" style="font-size: 25px"></i>
              <p style="margin-left: 5px">
               Quản lý đồ uống 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
           
              <li class="nav-item" >
                <a href="/product/add/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm đồ uống</p>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="/product/list/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách đồ uống</p>
                </a>
              </li>
            
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-table" style="font-size: 25px"></i>
              <p style="margin-left: 5px">
               Quản lý danh sách bàn
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">                        
              <li class="nav-item">
                <a href="/tables/list/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách bàn</p>
                </a>
              </li>
            
            </ul>
          </li>

          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-tags"></i>
              <p style="margin-left: 5px">
               Quản lý khuyễn mãi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">                        
              <li class="nav-item">
                <a href="/voucher/add/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tạo mã khuyến mãi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/voucher/list/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách mã khuyến mãi</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item">
            <a href="#" class="nav-link">
    
              <i class="fas fa-portrait" style="font-size: 25px"></i>
              <p style="margin-left: 5px">
               Quản lý khách hàng
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">                        
              <li class="nav-item">
                <a href="/customer/listAcc/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách khách hàng</p>
                </a>
              </li>
            
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-coins"></i>
              <p style="margin-left: 5px">
               Quản lý doanh thu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">                        
              <li class="nav-item">
                <a href="/revenue/indexDay/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Báo cáo doanh thu theo ngày</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/revenue/index/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Báo cáo doanh thu</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-money-check-alt"></i>
              <p style="margin-left: 5px">
               Quản lý nhân viên
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">                        
              <li class="nav-item">
                <a href="/attendance/confirm/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chấm công chưa hoàn thành</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/attendance/confirmCheckout/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chấm công chưa xác nhận</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/attendance/report/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thống kê lương nhân viên</p>
                </a>
              </li>
            </ul>
          </li>
          
          @endIf

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-shopping-cart"></i>
              <p style="margin-left: 5px">
                Quản lý bán hàng
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">                        
              <li class="nav-item">
                <a href="/order/tables/list/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách bàn phục vụ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/customer/bill/list/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách đơn khách order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/order/bill/list/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách đơn hàng mới</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/pay/bill/list/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách đơn hàng chưa thanh toán</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/order/bill/cancle/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách đơn hàng đã hủy</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/pay/revenue/list/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách đơn hàng đã thanh toán </p>
                </a>
              </li>
            </ul>
          </li>

         


    </div>
   
    <!-- /.sidebar -->
  </aside>
