<?php

namespace App\Repositories\Auth;

use App\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductInterface
{
    /**
     * @param array $input
     *
     * @return Product
     */
    public function create(array $input): Product;

    /**
     * @param int   $id
     *
     * @param array $input
     *
     * @return Product
     */
    public function update(int $id, array $input): Product;

    /**
     * @param int $id
     *
     * @return Product
     */
    public function show(int $id): Product;

    /**
     * @param array $input
     *
     * @return LengthAwarePaginator
     */
    public function filter(array $input): LengthAwarePaginator;

    /**
     * @param int $id
     *
     * @return Product
     */
    public function delete(int $id): Product;

}