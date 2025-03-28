@extends('master')
@section('title')
    {{ 'Sale Index' }}
@endsection
@section('content')
    <div class="content-wrapper">
        <sale-index :sales="{{ $sales }}">

        </sale-index>
    </div>
@endsection
