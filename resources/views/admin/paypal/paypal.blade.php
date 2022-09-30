@extends('layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               @include('layouts.errors-and-messages')        
               <form action = "{{ route('checkout.payment.paypal') }}" method = "POST">
                   @csrf
                   <button type = "submit" class="btn btn-primary"> Pay ($100) </button>
               </form>
           </div>
       </div>
   </div>
</div>
@endsection