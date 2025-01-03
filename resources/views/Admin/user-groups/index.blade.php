@extends('master')
@section('title') {{ 'User Groups' }}@endsection
@section('content')
    <div class="content-wrapper">
        <user-groups
        :all_modules="{{ $all_modules }}"
    ></user-groups>
    </div>
@endsection
