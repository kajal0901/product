<?php

namespace App\Repositories\Auth;

use App\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class CartRepository
{
    /**
     * store cart.
     *
     * @param array $input
     *
     * @return Cart
     */
    public function create(array $input): Cart
    {
        $cart = new Cart();
        if ($cart->store($input)->save()) {
            return $cart;
        }
    }


    /**
     * update cart
     *
     * @param int   $id
     * @param array $input
     *
     * @return JsonResponse
     */
    public function update(int $id, array $input)
    {
        $cart = $this->show($id);
        if ($cart->store($input)->save()) {
            return $cart;
        }
    }

    /**
     * search by id
     *
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        return $product = Cart::findOrFail($id);
    }

    /**
     * delete cart
     *
     * @param int $id
     *
     * @return mixed
     */
    public function deleteCart(int $id)
    {
        return Cart::findOrFail($id)->delete();
    }

    /**
     * get last deleted record
     *
     * @param int $id
     *
     * @return Cart[]|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|Collection
     */
    public function getDeletedRecord(int $id)
    {
        return Cart::withTrashed()->where('id', $id)->get();
    }
}