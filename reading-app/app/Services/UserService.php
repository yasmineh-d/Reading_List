<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAll()
    {
        $query = User::query();

        if (request()->has('search')) {
            $query->where('username', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%');
        }

        return $query->paginate(10);
    }
    public function getById(int $id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(int $id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id)
    {
        return User::destroy($id);
    }
}
