@extends('admin.main')
@section('head')
<style>
    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, 110px);
      column-gap: 20px;
      row-gap: 20px;      
      padding: 10px;
    }
    .grid-item {
      background-color: lightblue;
      border: 1px solid rgba(0, 0, 0, 0.8);
      padding: 20px;
      font-size: 20px;
      text-align: center;
    }
    </style>
@endsection

@section('content')
{{-- <div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
  <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
  <li class="nav-item">
  <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="/order/tables/list/1" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Trong nhà</a>
  </li>
  <li class="nav-item">
  <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="/order/tables/list/2" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Sân trước</a>
  </li>
  <li class="nav-item">
  <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="/order/tables/list/3" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Vườn sỏi</a>
  </li>
  </ul>
  </div>
  <div class="card-body">
  <div class="tab-content" id="custom-tabs-four-tabContent">
    
         
    <div class="grid-container" class="tab-pane fade active show"  role="tabpanel">
      @foreach ($listTable as $item)
      <div class="grid-item">{{$item->name}}</div>
      @endforeach
     
     
    </div>
  </div>
  </div>
  </div>
   --}}


   
    <div class="card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
    <li class="nav-item">
    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Trong nhà</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Sân trước</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Vườn sỏi</a>
    </li>
    
    </ul>
    </div>
    <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
    <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
      <div class="grid-container" class="tab-pane fade active show"  role="tabpanel">
        @foreach ($listTable1 as $item)
       @if(empty($item->status)) 
       <a class="btn btn-app bg-secondary" href="/menu/order/{{$item->id}}" id="{{$item->id}}" target="_blank">
        {{-- <span class="badge bg-teal">67</span> --}}
        <i class="fas fa-inbox"></i>
        {{$item->name}}
        </a>
         @else
         <a class="btn btn-app bg-danger" href="/menu/order/{{$item->id}}" id="{{$item->id}}" target="_blank">
          {{-- <span class="badge bg-teal">67</span> --}}
          <i class="fas fa-inbox"></i>
          {{$item->name}}
          </a>
         @endif
        @endforeach
      </div>
    </div>
    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
      <div class="grid-container" class="tab-pane fade active show"  role="tabpanel">
        @foreach ($listTable2 as $item)
        @if(empty($item->status)) 
        <a class="btn btn-app bg-secondary" href="/menu/order/{{$item->id}}" id="{{$item->id}}" target="_blank">
         {{-- <span class="badge bg-teal">67</span> --}}
         <i class="fas fa-inbox"></i>
         {{$item->name}}
         </a>
          @else
          <a class="btn btn-app bg-danger" href="/menu/order/{{$item->id}}" id="{{$item->id}}" target="_blank">
           {{-- <span class="badge bg-teal">67</span> --}}
           <i class="fas fa-inbox"></i>
           {{$item->name}}
           </a>
          @endif
        @endforeach
      </div>
    </div>
        <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
          <div class="grid-container" class="tab-pane fade active show"  role="tabpanel">
            @foreach ($listTable3 as $item)
            @if(empty($item->status)) 
            <a class="btn btn-app bg-secondary" href="/menu/order/{{$item->id}}" id="{{$item->id}}" target="_blank">
             {{-- <span class="badge bg-teal">67</span> --}}
             <i class="fas fa-inbox"></i>
             {{$item->name}}
             </a>
              @else
              <a class="btn btn-app bg-danger" href="/menu/order/{{$item->id}}" id="{{$item->id}}" target="_blank">
               {{-- <span class="badge bg-teal">67</span> --}}
               <i class="fas fa-inbox"></i>
               {{$item->name}}
               </a>
              @endif
            @endforeach
           
        </div>
        </div>
    </div>
    </div>
    </div>
    
   
  

@endsection
@section('footer')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if(Session::has('success'))
<script>toastr.success("{{Session::get('success')}}");</script>
@endif
<script type="module">
   
  Echo.private('OrderChannel')
  .listen('NewOrder', (e) => {
   
    var element = document.getElementById(e.o.table.id);
if (element.classList.contains("bg-secondary")) {
    // Do something
    element.classList.remove("bg-secondary");
    element.classList.add("bg-danger");
    
}
     
    
})
</script>
<script type="module">
 
  Echo.private('cancleOrders')
   .listen('cancleOrder', (e) => {
  
    
    var element = document.getElementById(e.o.table_id);

    // Do something
    element.classList.remove("bg-danger");
    element.classList.add("bg-secondary");
    

  

 
})

</script>
@endsection

@push('scripts')
<script type="module">
 
  Echo.private('payChannel')
   .listen('payOrder', (e) => {
  
    var element = document.getElementById(e.o.table_id);

// Do something
element.classList.remove("bg-danger");
element.classList.add("bg-secondary");


 
})

</script>

@endpush