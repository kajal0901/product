<?php

namespace App\Repositories\Auth;

use App\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
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
        if ($product->store($input)->save()) {
            return $product;
        }
    }

    /**
     * update product.
     *
     * @param int   $id
     * @param array $input
     *
     * @return JsonResponse
     */
    public function update(int $id, array $input): JsonResponse
    {
        $product = $this->show($id);
        return $product->store($input)->save();
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id)
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
    public function filter(array $input)
    {
        $name = isset($input["filter"]["name"]) ? $input["filter"]["name"] : '';
        $description = isset($input["filter"]["description"]) ? $input["filter"]["description"] : '';
        return Product::Where('name', 'like', '%' . $name . '%')
            ->Where('description', 'like', '%' . $description . '%')
            ->orderBy($input['orderByColumn'], $input['orderBy'])
            ->paginate(5);

    }

    /**
     * deleted record from cart.
     * method for last deleted record information.
     * @param int $id
     *
     * @return Product[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
     */
    public function getDeletedRecord(int $id)
    {
        return Product::withTrashed()->where('id', $id)->get();
    }
}