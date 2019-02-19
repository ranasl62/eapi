<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Model\Product;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function _construct()
    {
        $this->middleware('auth:api')->except('index','show');
    } 

    public function index()
    {
        return ProductCollection::collection(Product::paginate(5));
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
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name       = $request->name;
        $product->detail     = $request->description;
        $product->stock      = $request->stock;
        $product->price      = $request->price;
        $product->discount   = $request->discount;
        $product->save();
        return response([
                'data' => new ProductResource($product)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modal\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modal\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modal\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try{
            $request['detail']=$request->description;
            unset($request['description']);
            $product->update($request->all());
            return response([
                    'data' => new ProductResource($product)
            ],202);
    }catch(\Exception $a){
        return $a;
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modal\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try{

            $product->delete();
            return response([], Response::HTTP_NO_CONTENT);
        }catch(\Exception $a){
            return $a;
        }
    }
}
