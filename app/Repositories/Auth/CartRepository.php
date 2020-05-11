<?php

namespace App\Repositories\Auth;

use App\Cart;


class CartRepository implements CartInterface
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
        $cart->store($input)->save();
        return $cart;
    }

    /**
     * update cart
     *
     * @param int   $id
     * @param array $input
     *
     * @return Cart
     */
    public function update(int $id, array $input): Cart
    {
        $cart = $this->show($id);
        $cart->store($input)->save();
        return $cart;
    }

    /**
     * search by id
     *
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id): Cart
    {
        return $cart = Cart::findOrFail($id);
    }

    /**
     * delete cart
     *
     * @param int $id
     *
     * @return mixed
     */
    public function delete(int $id): Cart
    {
        return Cart::findOrFail($id)->delete();
    }

    /**
     * get last deleted record
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getDeletedRecord(int $id)
    {
        return Cart::withTrashed()->where('id', $id)->get();
    }
}