<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $data = $this->userService->getAll();
        return view('users.index', compact('data'));
    }
}
