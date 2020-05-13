<?php

namespace App\Repositories\Auth;

use App\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderInterface
{
    /**
     * @param array $input
     *
     * @return Order
     */
    public function create(array $input): Order;

    /**
     * @param int   $id
     *
     * @param array $input
     *
     * @return Order
     */
    public function update(int $id, array $input): Order;

    /**
     * @param int $id
     *
     * @return Order
     */
    public function show(int $id): Order;

    /**
     * @param array $input
     *
     * @return LengthAwarePaginator
     */
    public function filter(array $input): LengthAwarePaginator;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool ;

}