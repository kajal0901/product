<?php

namespace App\Repositories\Auth;

use App\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderInterface
{
    /**
     * store cart.
     *
     * @param array $input
     *
     * @return Order
     */
    public function create(array $input): Order
    {
        $order = new Order();
        $order->store($input)->save();
        return $order;
    }

    /**
     * update cart
     *
     * @param int   $id
     * @param array $input
     *
     * @return Order
     */
    public function update(int $id, array $input): Order
    {
        $order = $this->show($id);
        $order->store($input)->save();
        return $order;
    }

    /**
     * search by id
     *
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id): Order
    {
        return $order = Order::findOrFail($id);
    }

    /**
     * delete cart
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Order::findOrFail($id)->delete();
    }

    /**
     * @param array $input
     *
     * @return LengthAwarePaginator
     */
    public function filter(array $input): LengthAwarePaginator
    {
        $status = isset($input["filter"]["status"]) ? $input["filter"]["status"] : '';
        $name = isset($input["filter"]["name"]) ? $input["filter"]["name"] : '';
        $perPage = $input['perPage'] ?? 5;
        return Order::Where('status', 'like', '%' . $status . '%')
            ->Where('name', 'like', '%' . $name . '%')
            ->orderBy($input['orderByColumn'], $input['orderBy'])
            ->paginate($perPage);
    }

}