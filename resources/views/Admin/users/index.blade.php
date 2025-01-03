@extends('master')
@section('title') {{ 'Users' }}@endsection
@section('content')
    <div class="content-wrapper">
        <users
        :auth-role-id="{{ Auth::user()->role_id }}"
        ></users>
    </div>
@endsection
