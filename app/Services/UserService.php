<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * hhh
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function getList(array $filter = [])
    {
        $query = $this->user->query()->latest();
        
        if (Arr::has($filter, 'with')) {
            $query->with(Arr::get($filter, 'with'));
        }

        if (Arr::has($filter, 'filter')) {
            $query->where(Arr::get($filter, 'filter'));
        }

        if (Arr::has($filter, 'search')) {
            foreach (Arr::get($filter, 'search') as $column => $value) {
                $query->where($column, 'like', "%{$value}%");
            }
        }

        if (Arr::has($filter, 'paginate')) {
            return $query->paginate(Arr::get($filter, 'paginate'));
        }

        return $query->get();
    }

    public function create($data)
    {
        $user = $this->user->fill($data);
        $user->password = Hash::make($data['password']);

        $user->save();


        if (isset($data['roles'])) {
            $user->assignRole($data['roles']);
        }

        return $user;
    }

    public function update ($data, $user)
    {
        $user->update([
            'name' => $data['name'],
        ]);
        if ($data['password']) {
            $user->update([
                'password' => Hash::make($data['password']),
            ]);
        }
        $roles = $data->roles ?? [];
        $user->syncRoles($roles);
    }

}
