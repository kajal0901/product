<?php

namespace App\Repositories\Auth;

use App\Cart;
use Illuminate\Http\JsonResponse;

class CartRepository
{
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
     * @param int   $id
     * @param array $input
     *
     * @return JsonResponse
     */
    public function update(int $id, array $input)
    {
        $model = $this->show($id);
        $model->fill($input);
        $model->save();
        return $model;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        return $product = Cart::findOrFail($id);
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function deleteCart(int $id)
    {
        return Cart::findOrFail($id)->delete();
    }

}