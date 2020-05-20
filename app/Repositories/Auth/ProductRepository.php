<?php

namespace App\Repositories\Auth;

use App\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class ProductRepository implements ProductInterface
{

    /**
     * @var
     */
    protected $model;

    /**
     * ProductRepository constructor.
     *
     * @param Product $model
     */
    public function __construct(
        Product $model
    )
    {
        $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $input): Product
    {
        $product = new Product();
        $product->store($input)->save();
        return $product;
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $input): Product
    {
        $product = $this->show($id);
        $product->store($input)->save();
        return $product;
    }

    /**
     * {@inheritDoc}
     */
    public function show(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): Product
    {
        return Product::findOrFail($id)->delete();
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

    /**
     * deleted record from cart.
     * method for last deleted record information.
     *
     * @param int $id
     *
     * @return Product[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
     */
    public function getDeletedRecord(int $id)
    {
        return Product::withTrashed()->where('id', $id)->get();
    }
}