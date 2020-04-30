<?php

namespace App\Repositories\Auth;


use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class ProductRepository
{

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param array $input
     *
     * @return Product
     */
    public function create(array $input): Product
    {
        return Product::create(
            [
                'name' => $input['name'],
                'price' => $input['price'],
                'description' => $input['description'],
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    public function getProduct()
    {
        return $products = Product::paginate(5);
    }

    /**
     * @param array $input \
     */
    public function update(array $input)
    {
        /**
         * Todo implement Product update code
         */
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return $product = Product::findOrFail($id);

    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function deleteProduct(array $input)
    {
        $product = Product::findOrFail($input['id']);
        return $product->delete();
    }

}