@extends('master')
@section('title')
    {{ 'Dashboard' }}
@endsection
@section('content')
    <div class="content-wrapper">
        
        <dashboard 
            :sale-amount="{{ $saleAmount }}" 
            :total-customers="{{ $totalCustomers }}"
            :total-products="{{ $totalProducts }}" 
            :total-categories="{{ $totalCategories }}">
        </dashboard>
    </div>
@endsection