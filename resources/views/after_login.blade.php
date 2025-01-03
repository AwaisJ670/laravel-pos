@extends('master')
@section('title') {{ 'Welcome ' }}@endsection
@section('content')
<div class="content-wrapper text-center justify-content-center align-items-center d-flex">
    <div>
        <img src="{{asset('images/logo.ico')}}" style="width:50%"  />
        <h1 class="mb-0" style="font-size: 2rem">Welcome!</h1>
        <h2 class="text-success" style="font-size: 3rem">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
    </div>
</div>
@endsection
