@extends('layouts.admin')

@section('content')
<div class="visible-print text-center">
    <h1>QR Code for  Company</h1>
    {!! QrCode::size(250)->generate(route('company.index')); !!}
</div>
<div class="visible-print text-center">
    <h1>QR Code for  Employee</h1>
    {!! QrCode::size(250)->generate(route('employee.index')); !!}
</div>
@endsection