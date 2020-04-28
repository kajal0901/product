<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {

        $oProduct =  Product::create(
            [
                'name' => $request['name'],
                'price' => $request['price'],
                'description' => $request['description'],
            ]
        );
        return response()->json(['product' => $oProduct, 'message' => 'Product Added successfully']);

    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $id = $request['id'];
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $id = $request['id'];
        $productData = Product::findOrFail($id);

        $productData->name = $request->input('name');
        $productData->price = $request->input('price');
        $productData->description = $request->input('description');
        $productData->save();
        return response()->json(['user' => $productData, 'message' => 'Product Updated']);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $id = $request['id'];
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json('product deleted');
    }

}
