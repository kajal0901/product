<?php

namespace App\Repositories\Auth;

use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class AuthRepository implements UserInterface
{


    /**
     * @var Model
     */
    protected $model;

    /**
     * @param array $input
     *
     * @return User
     */
    public function create(array $input): User
    {
        return User::create(
            [
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]
        );

    }

    /**
     * @param $id
     *
     * @return User
     */
    public function find($id): User
    {
        return User::findOrFail($id);
    }

    /**
     * @param array $input
     *
     * @return LengthAwarePaginator
     */
    public function getAll(array $input): LengthAwarePaginator
    {
        $name = isset($input["filter"]["name"]) ? $input["filter"]["name"] : '';
        $email = isset($input["filter"]["email"]) ? $input["filter"]["email"] : '';
        $perPage = $input['perPage'] ?? 5;
        return User::Where('name', 'like', '%' . $name . '%')
            ->Where('email', 'like', '%' . $email . '%')
            ->orderBy($input['orderByColumn'], $input['orderBy'])
            ->paginate($perPage);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
       return  User::findOrFail($id)->delete();
    }
}