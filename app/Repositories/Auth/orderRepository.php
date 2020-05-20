<?php

namespace App\Repositories\Auth;

use App\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderInterface
{

    /**
     * @var
     */
    protected $model;

    /**
     * OrderRepository constructor.
     *
     * @param Order $model
     */
    public function __construct(
        Order $model
    )
    {
        $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $input): Order
    {
        $order = new Order();
        $order->store($input)->save();
        return $order;
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $input): Order
    {
        $order = $this->show($id);
        $order->store($input)->save();
        return $order;
    }

    /**
     * {@inheritDoc}
     */
    public function show(int $id): Order
    {
        return $order = Order::findOrFail($id);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): bool
    {
        return Order::findOrFail($id)->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function filter(array $input): LengthAwarePaginator
    {
        $perPage = $input['perPage'] ?? 5;
        return $this->model->query()
            ->applyFilter($input)
            ->applySort($input)
            ->paginate($perPage);
    }

}