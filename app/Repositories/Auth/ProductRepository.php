<?php

namespace App\Repositories\Auth;

use App\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class ProductRepository
{
    /**
     * store product.
     *
     * @param array $input
     *
     * @return Product
     */
    public function create(array $input): Product
    {
        $product = new Product();
        $product->store($input)->save();
        return $product;
    }

    /**
     * update product.
     *
     * @param int   $id
     * @param array $input
     *
     * @return Product
     */
    public function update(int $id, array $input): Product
    {
        $product = $this->show($id);
        $product->store($input)->save();
        return $product;
    }

    /**
     * @param int $id
     *
     * @return Product
     */
    public function show(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function deleteProduct(int $id)
    {
        return Product::findOrFail($id)->delete();
    }

    /**
     * filter method for product data
     *
     * @param array $input
     *
     * @return LengthAwarePaginator
     */
    public function filter(array $input): LengthAwarePaginator
    {
        $name = isset($input["filter"]["name"]) ? $input["filter"]["name"] : '';
        $description = isset($input["filter"]["description"]) ? $input["filter"]["description"] : '';
        $perPage = $input['perPage'] ?? 5;
        return Product::Where('name', 'like', '%' . $name . '%')
            ->Where('description', 'like', '%' . $description . '%')
            ->orderBy($input['orderByColumn'], $input['orderBy'])
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