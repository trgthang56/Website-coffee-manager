@extends('admin.main')
@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
    .highlight {
        animation: blink 1s infinite alternate; /* Kích hoạt animation */
    }

    @keyframes blink {
        from {
            background-color: rgb(51, 112, 51);
        }
        to {
            background-color: initial;
        }
    }
</style>

<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endsection
@section('tools')

<form action="/revenue/searchDay/" method="POST" >

        <div class="row">
            {{-- <label  for="start_date">Từ ngày:</label>
            <input type="date" id="start_date" name="daystart"  max="" required> --}}
            {{-- <label for="date_range">Chọn khoảng ngày:</label>&nbsp;&nbsp; --}}
            <input type="text" id="date_range" name="date" required>
       
        {{-- <div class="col-4">
            <label   for="end_date">Đến ngày:</label>
            <input type="date" id="end_date" name="dayend"   max="" required>
        </div> --}}
      
        
                 <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
                </button>
               
        </div>
    
 
    @csrf
     </form>
       
@endsection
@section('content1')


<div class="row" >
    
    <div class="col-lg-3 col-6">
    
    <div class="small-box bg-info">
    <div class="inner">
    <h3>{{$orderCount}}</h3>
    <p>Số lượng đơn hàng</p>
    </div>
    <div class="icon">
        <i class="ion ion-bag"></i>
        </div>
    <a href="#billPay" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    </div>
    
    <div class="col-lg-3 col-6">
    
    <div class="small-box bg-success">
    <div class="inner">
    <h3> <?php   $formattedNumber1 = number_format($revenue);echo $formattedNumber1; ?>đ<sup style="font-size: 20px"></sup></h3>
    <p>Doanh thu</p>
    </div>
    <div class="icon">
    <i class="ion ion-stats-bars"></i>
    </div>
    <a class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    </div>
    
    <div class="col-lg-3 col-6">
    
    <div class="small-box bg-warning">
    <div class="inner">
    <h3>{{$userCount}}</h3>
    <p>Số khách hàng đăng ký </p>
    </div>
    <div class="icon">
    <i class="ion ion-person-add"></i>
    </div>
    <a href="/customer/listAcc/" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    </div>
    
    <div class="col-lg-3 col-6">
    
    <div class="small-box bg-danger">
    <div class="inner">
    <h3>{{$orderCancleCount}}</h3>
    <p>Số đơn hàng bị hủy</p></p>
    </div>
    <div class="icon">
    <i class="ion ion-pie-graph"></i>
    </div>
    <a href="#billCancle" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    </div>
    
    </div>
{{-- <canvas id="myDonutChart" width="400" height="200"></canvas> --}}
<div class="row">
    <div class="col-md-6">
        <div class="card card-success" >
            <div class="card-header">
            <h3 class="card-title">Số lượng bán của mỗi đồ uống</h3>
            <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
            </button>
            </div>
            </div>
            <div class="card-body">
            <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            <canvas id="myChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 304px;" width="608" height="500" class="chartjs-render-monitor"></canvas>
            </div>
            </div>
            
            </div>
    </div>
    <div class="col-md-6">
        <div class="card card-danger">
            <div class="card-header">
            <h3 class="card-title">Số đơn trên mỗi phương thức thanh toán</h3>
            <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
            </button>
            </div>
            </div>
            <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 304px;" width="608" height="500" class="chartjs-render-monitor"></canvas>
            </div>
            
            </div>
    </div>
</div>

       
 <div class="row">
    <div class="col-md-6">
        <div class="card card-primary" >
            <div class="card-header">
            <h3 class="card-title">Thông tin chi tiết đơn hàng đã thanh toán</h3>
            <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
            </button>
            </div>
            </div>
            <div class="card-body">
            <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            <div class="table-responsive p-0" style="height: 250px; max-height: 250px; max-width: 100%; display: block; " >
                <table class="table table-hover text-nowrap" id="billPay">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>Người lên đơn</th>
                    <th>Tên bàn</th>
                    <th>Nhân viên thanh toán</th>
                    <th>Trạng thái đơn</th>
                    <th>Thời gian tạo</th>
                    <th>Thời gian thanh toán đơn</th>
                    <th>Voucher đã dùng</th>
                    <th>PTTT</th>
                    <th>Giá Tiền</th>
                    <th>Chi tiết</th>
                    </tr>
                    </thead>
                    <tbody >
                        @foreach ($orders as $item)
                    <tr>
                    <td >{{$item->id}}</td>
                    <td >{{$item->user->name}}</td>
                    <td >{{$item->table->name}} </td>
                    <td >{{$item->userPay->name}}</td> 
                    <td >{{$item->status}}</td>
                    <td >{{$item->created_at}}</td>
                    <td id="update-{{$item->id}}">{{$item->updated_at}}</td>
                    <td>@if($item->code != null) {{$item->voucher->code}}@else Không sử dụng voucher @endif</td>
                    <td >{{$item->payMethod}}</td>
                    <td > <?php   $formattedNumber1 = number_format($item->total);echo $formattedNumber1; ?> 
                        &nbsp;đ</td></td>
                    <td ><a class="btn btn-app" href="/pay/reDetail/show/{{ $item->id }}" data-id="{{$item->id}}" >
                        <i class="fas fa-edit"></i> Chi tiết
                        <span class="badge bg-danger" id="new_{{$item->id}}"></span>
                        </a>
                        
                       
                     
                       
                    </a>
                 
                   
                </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
            </div>
            
            </div>
        </div>

      
            <div class="col-md-6">
                <div class="card card-danger">
                    <div class="card-header">
                    <h3 class="card-title">Thông tin chi tiết đơn hàng hủy</h3>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                    </div>
                    </div>
                    <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>              
                        <div class="table-responsive p-0" style="height: 250px; max-height: 250px; max-width: 100%; display: block; " >
                            <table class="table table-hover text-nowrap" id="billCancle">
                                <thead>
                                <tr>
                                <th>ID</th>
                                <th>Người lên đơn</th>
                                <th>Tên bàn</th>
                                <th>Ghi chú đơn hàng</th>
                                <th>Trạng thái đơn</th>
                                <th>Thời gian tạo</th>
                                <th>Thời gian hủy đơn</th>
                                <th>Chi tiết</th>
                                </tr>
                                </thead>
                                <tbody >
                                    @foreach ($orderCancle as $item)
                                <tr>
                                <td >{{$item->id}}</td>
                                <td > @if($item->user_id == 0) Khách order @else {{$item->user->name}} @endIF</td>
                                <td >{{$item->table->name}} </td>
                                <td >@if(empty($item->mess)) Không có ghi chú @else {{$item->mess}} @endIF</td> 
                                <td >{{$item->status}}</td>
                                <td >{{$item->created_at}}</td>
                                <td id="update-{{$item->id}}">{{$item->updated_at}}</td>
                                <td ><a class="btn btn-app"  href="/order/detailCancle/show/{{ $item->id }}" data-id="{{$item->id}}" >
                                    <i class="fas fa-edit"></i> Chi tiết
                                    </a>
                                    
                                   
                                 
                                   
                                </a>
                             
                               
                            </td>
                                </tr>
                                @endforeach
                                </tbody>
                                </table>
                        </div>
                        
                      
                
                </div>
                    
                    </div>
            </div>
    </div>
 
          




@endsection

@section('footer')
<script>
    var products =  {!! json_encode($products, JSON_HEX_QUOT) !!};
    document.addEventListener('DOMContentLoaded', function () {
        var link = document.querySelector('a[href="#billPay"]');
    if (link) {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a

            var targetDiv = document.getElementById('billPay');
            if (targetDiv) {
                // Cuộn đến phần tử div mục tiêu
                targetDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Thêm lớp highlight để tạo hiệu ứng nhấp nháy
        targetDiv.classList.add('highlight');

// Xóa lớp highlight sau 1.5 giây
setTimeout(function() {
    targetDiv.classList.remove('highlight');
}, 2500);
            }
        });
    }
    var link1 = document.querySelector('a[href="#billCancle"]');
    if (link1) {
        link1.addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a

            var targetDiv = document.getElementById('billCancle');
            if (targetDiv) {
                // Cuộn đến phần tử div mục tiêu
                targetDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Thêm lớp highlight để tạo hiệu ứng nhấp nháy
        targetDiv.classList.add('highlight');

// Xóa lớp highlight sau 1.5 giây
setTimeout(function() {
    targetDiv.classList.remove('highlight');
}, 2500);
            }
        });
    }
       
        const labels = products.map(item => item.name);
        const values = @json($soLuongMon);
     
         // Mảng màu cố định
         const colors = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                // Thêm màu khác nếu cần
            ];

            // Mảng màu sẽ sử dụng cho mỗi đồ uống
            const backgroundColors = labels.map((label, index) => colors[index % colors.length]);

     var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Số lượng bán',
                data: values,
                backgroundColor: backgroundColors,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
    });
        // Đoạn mã JavaScript vẽ biểu đồ sẽ ở đây
        // ...

    const tienMat = {{$tienMat}};
    const vnPay = {{$vnPay}};
        var ctx1 = document.getElementById('donutChart').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['VnPay','Tiền mặt'],
            datasets: [{
                label: 'Số lượng đơn',
                data: [vnPay,tienMat],
                backgroundColor: [
                'rgb(255, 99, 132)',
                 'rgb(54, 162, 235)'    
                    ],
                hoverOffset: 4
            }]
        }
    });

  
        // Đoạn mã JavaScript vẽ biểu đồ sẽ ở đây
        // ...
    });
    var date =   @json($today);
// Kích hoạt Flatpickr cho range date với định dạng ngày dd/mm/yyyy và hiển thị chữ "đến"
flatpickr("#date_range", {
    mode: "single",  // Chế độ chọn range date
    dateFormat: "d-m-Y",  // Định dạng ngày dd/mm/yyyy
    locale: {
        weekdays: {
            shorthand: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            longhand: [
                "Chủ Nhật",
                "Thứ Hai",
                "Thứ Ba",
                "Thứ Tư",
                "Thứ Năm",
                "Thứ Sáu",
                "Thứ Bảy"
            ]
        },
        months: {
            shorthand: [
                "Th 1",
                "Th 2",
                "Th 3",
                "Th 4",
                "Th 5",
                "Th 6",
                "Th 7",
                "Th 8",
                "Th 9",
                "Th 10",
                "Th 11",
                "Th 12"
            ],
            longhand: [
                "Tháng Một",
                "Tháng Hai",
                "Tháng Ba",
                "Tháng Tư",
                "Tháng Năm",
                "Tháng Sáu",
                "Tháng Bảy",
                "Tháng Tám",
                "Tháng Chín",
                "Tháng Mười",
                "Tháng Mười Một",
                "Tháng Mười Hai"
            ]
        }
    },
    maxDate: "today",
    defaultDate: date
  
});
</script>




    {{-- <script>
        var ctx = document.getElementById('myDonutChart').getContext('2d');
        var myDonutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                cutout: '70%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    </script> --}}

@endsection