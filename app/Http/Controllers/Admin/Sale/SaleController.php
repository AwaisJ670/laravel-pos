<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Models\Admin\Sale;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\Customer;
use App\Models\Admin\Inventory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('Admin.sale.salepannel', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
            'customer.name' => 'required|string|max:255',
            'customer.phone' => 'required|string|max:20',
            'customer.email' => 'nullable|email|max:255',
            'customer.payment_method' => 'required|in:cash,card,bank_transfer',
        ]);
        $authId = Auth::id();

        DB::beginTransaction();
        try {
            // Create customer
            $customer = Customer::create([
                'name' => $validatedData['customer']['name'],
                'email' => $validatedData['customer']['email'] ?? null,
                'phone' => $validatedData['customer']['phone'],
                'payment_method' => $validatedData['customer']['payment_method'],
            ]);
    
            // Create sale
            $sale = Sale::create([
                'customer_id' => $customer->id,
                'amount' => $validatedData['amount'],
                'user_id' => Auth::id(),
            ]);
    
            $inventoryItems = [];
    
            foreach ($validatedData['items'] as $item) {
                // Fetch product and check stock
                $product = Product::find($item['id']);
    
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Not enough stock for product: {$product->name}");
                }
    
                // Deduct stock
                $product->decrement('stock', $item['quantity']);
    
                // Add inventory record
                $inventoryItems[] = [
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => (int) $item['quantity'],
                    'price' => (float) $item['price'],
                    'amount' => (float) $item['amount'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
    
            // Bulk insert inventory records
            Inventory::insert($inventoryItems);
    
            DB::commit();
            return response()->json(['message' => 'Sale recorded successfully'], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage()], 500);
        } 
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
