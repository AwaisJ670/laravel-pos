<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Customer;
use App\Models\Admin\Product;
use App\Models\Admin\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $saleAmount = Sale::sum('amount');
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();


        return view('dashboard', compact('saleAmount', 'totalCustomers', 'totalProducts', 'totalCategories'));
    }
}
