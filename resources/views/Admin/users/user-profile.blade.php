@extends('master')
@section('title') {{ 'Users Profile' }}@endsection
@section('content')
    <div class="content-wrapper">
        <user-profile
        :user="{{ Auth::user() }}"
    ></user-profile>
    </div>
@endsection
