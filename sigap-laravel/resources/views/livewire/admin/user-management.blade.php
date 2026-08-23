<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-xl font-medium mb-4">Kelola Pengguna</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full text-sm border-collapse">
        <thead>
            <tr class="text-left border-b">
                <th class="py-2">Nama</th>
                <th class="py-2">Email</th>
                <th class="py-2">Role</th>
                <th class="py-2">Ubah role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr wire:key="user-{{ $user->id }}" class="border-b">
                    <td class="py-2">{{ $user->name }}</td>
                    <td class="py-2">{{ $user->email }}</td>
                    <td class="py-2">{{ $user->roles->pluck('name')->join(', ') ?: '-' }}</td>
                    <td class="py-2">
                        <select wire:change="assignRole({{ $user->id }}, $event.target.value)" class="border rounded p-1">
                            <option value="">-- pilih --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
