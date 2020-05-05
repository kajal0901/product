<?php

namespace App\Repositories\Auth;

use App\Product;
use Illuminate\Http\JsonResponse;

class ProductRepository
{

    /**
     * @param array $input
     *
     * @return Product
     */
    public function create(array $input): Product
    {
        return Product::create(
            [
                'name' => $input['name'],
                'price' => $input['price'],
                'description' => $input['description'],
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    public function getProduct()
    {
        return Product::paginate(5);
    }

    /**
     * @param int   $id
     * @param array $input
     *
     * @return JsonResponse
     */
    public function update(int $id, array $input)
    {
        $model = $this->show($id);
        $model->fill($input);
        $model->save();
        return $model;
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

}