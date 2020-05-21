<?php

namespace App\Repositories\Auth;

use App\Cart;


class CartRepository implements CartInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(array $input): Cart
    {
        $cart = new Cart();
        $cart->store($input)->save();
        return $cart;
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $input): Cart
    {
        $cart = $this->show($id);
        $cart->store($input)->save();
        return $cart;
    }

    /**
     * {@inheritDoc}
     */
    public function show(int $id): Cart
    {
        return $cart = Cart::findOrFail($id);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): bool
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