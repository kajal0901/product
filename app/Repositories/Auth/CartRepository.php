<?php

namespace App\Repositories\Auth;


use App\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class CartRepository
{

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param array $input
     *
     * @return Cart
     */
    public function create(array $input): Cart
    {

        return Cart::create(
            [
                'name' => $input['name'],
                'quantity' => $input['quantity'],
                'product_id' => $input['product_id'],
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
        return $product = Cart::findOrFail($id);

    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function deleteCart(array $input)
    {
        $product = Cart::findOrFail($input['id']);
        return $product->delete();
    }

}