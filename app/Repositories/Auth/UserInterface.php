<?php

namespace App\Repositories\Auth;

use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserInterface
{
    /**
     * @param array $input
     *
     * @return User
     */
    public function create(array $input): User;

    /**
     * @param array $input
     *
     * @return LengthAwarePaginator
     */
    public function getAll(array $input): LengthAwarePaginator;

    /**
     * @param $id
     *
     * @return User
     */
    public function find($id): User;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool;

}