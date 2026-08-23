<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Component;

class UserManagement extends Component
{
    public function assignRole($userId, $roleName)
    {
        $user = User::findOrFail($userId);
        $user->syncRoles([$roleName]);
        session()->flash('success', "Role {$user->name} diubah menjadi {$roleName}.");
    }

    public function render()
    {
        return view('livewire.admin.user-management', [
            'users' => User::with('roles')->latest()->get(),
            'roles' => Role::all(),
        ]);
    }
}
