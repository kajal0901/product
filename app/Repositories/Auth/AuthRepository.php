<?php

namespace App\Repositories\Auth;

use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;


class AuthRepository implements UserInterface
{

    /**
     * @var
     */
    protected $model;

    /**
     * ProductRepository constructor.
     *
     * @param User $model
     */
    public function __construct(
        User $model
    )
    {
        $this->model = $model;
    }

    /**
     * @param array $input
     *
     * @return User
     */
    public function create(array $input): User
    {
        $oUser = User::create(
            [
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]
        );

        $this->assignRole($oUser, config('app.DEFAULT_USER_ROLE'));

        return $oUser;
    }

    /**
     * @param User   $user
     * @param string $role
     *
     * @return User
     */
    public function assignRole(User $user, string $role): User
    {
        return $user->assignRole($role);
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
        $perPage = $input['perPage'] ?? 5;
        return $this->model->query()
            ->applyFilter($input)
            ->applySort($input)
            ->paginate($perPage);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return User::findOrFail($id)->delete();
    }
}