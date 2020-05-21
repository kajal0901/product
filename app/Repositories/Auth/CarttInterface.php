<?php

namespace App\Repositories\Auth;

use App\Cart;


interface CartInterface
{
    /**
     * @param array $input
     *
     * @return Cart
     */
    public function create(array $input): Cart;

    /**
     * @param int   $id
     *
     * @param array $input
     *
     * @return Cart
     */
    public function update(int $id, array $input): Cart;

    /**
     * @param int $id
     *
     * @return Cart
     */
    public function show(int $id): Cart;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool;

}