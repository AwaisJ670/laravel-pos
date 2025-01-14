@extends('master')
@section('title') {{ 'Roles' }}@endsection
@section('content')
    <div class="content-wrapper">
        <roles
        :all_modules="{{ $all_modules }}"
        ></roles>
    </div>
@endsection
