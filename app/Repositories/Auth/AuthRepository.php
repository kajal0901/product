<?php

namespace App\Repositories\Auth;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AuthRepository
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
        $user = User::create(
            [
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]
        );
        return $user;
    }
}