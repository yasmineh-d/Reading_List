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

    public function create()
    {
        return view('users.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|string',
            'status' => 'required|string',
        ]);

        $this->userService->create($validated);
        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(int $id)
    {
        $user = $this->userService->getById($id);
        return view('users.edit', compact('user'));
    }

    public function update(\Illuminate\Http\Request $request, int $id)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string',
            'status' => 'required|string',
        ]);

        $this->userService->update($id, $validated);
        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(int $id)
    {
        $this->userService->delete($id);
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function toggleStatus(int $id)
    {
        $user = $this->userService->getById($id);
        $newStatus = $user->status === 'Actif' ? 'Inactif' : 'Actif';
        $this->userService->update($id, ['status' => $newStatus]);
        return redirect()->route('users.index')->with('success', 'Statut mis à jour.');
    }
}
