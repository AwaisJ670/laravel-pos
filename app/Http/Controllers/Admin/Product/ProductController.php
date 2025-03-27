<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
                'code' => 'required',
                'category_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 422);
            }
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->code = $request->code;
            $product->category_id = $request->category_id;

            $product->save();
            DB::commit();
            $product->load('category:id,name');

            return response()->json(['message' => 'Product added successfully!', 'product' => $product]);
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $product = Product::findOrFail($id);
            return response()->json($product);
        }
        catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
                'code' => 'required',
                'category_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 422);
            }
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->code = $request->code;
            $product->category_id = $request->category_id;

            $product->save();
            DB::commit();
            $product->load('category:id,name');

            return response()->json(['message' => 'Product updated successfully!', 'product' => $product]);
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(['message' => 'Product Deleted Successfully']);
    }

    public function uploadProductImage(Request $request,$id){
        if($request->hasFile('image')){
            $product = Product::select('id', 'name','category_id','code','price','stock','image')
                ->where('id',$id)->first();

            if (Storage::exists('public/products_images/' . $product->image)) {
                Storage::delete('public/products_images/' . $product->image);
            }
            $productImageName =  $id . '_image.' . pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
            $request->image->move(storage_path('app/public/products_images'), $productImageName);
            $product->image = $productImageName;
            $product->save();

            $product->load('category:id,name');

            return response()->json(['message' => 'Product image uploaded successfully!','product' => $product], 200);
        }
    }

    public function getProducts(){
        $products = Product::select('id','name','category_id','code','price','stock','image')
                    ->with('category:id,name')
                    ->where('is_active',1)
                    ->get();

        return response()->json($products);            
    }

}
