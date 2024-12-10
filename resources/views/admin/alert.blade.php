<!-- /resources/views/post/create.blade.php -->


 
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 
<!-- Create Post Form -->
@if(Session::has('error'))
<div class="alert alert-danger">
    <ul>
      {{Session::get('error')}}
    </ul>
</div>
@endif

{{-- @if(Session::has('success'))
<div class="alert alert-success">
    <ul>
      {{Session::get('success')}}
    </ul>
</div>
@endif --}}