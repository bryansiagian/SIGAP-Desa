<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UserManagement extends Component
{
    public function assignRole($userId, $roleName)
    {
        $user = User::findOrFail($userId);
        $user->syncRoles([$roleName]);
        $this->dispatch('toast', message: "Role {$user->name} diubah menjadi {$roleName}.", type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.user-management', [
            'users' => User::with('roles')->latest()->get(),
            'roles' => Role::all(),
        ]);
    }
}
