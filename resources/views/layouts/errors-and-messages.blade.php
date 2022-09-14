@if($errors->all())

@foreach($errors->all() as $message)
<div class="alert alert-warning alert-dismissible" role="alert">
    {!! $message !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endforeach

@elseif(session()->has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {!! session()->get('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
  
@elseif(session()->has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    {!! session()->get('error') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible" role="alert">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif