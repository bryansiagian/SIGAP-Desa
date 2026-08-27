<div class="max-w-3xl mx-auto px-6 py-10">
    <h1 class="font-display text-2xl font-semibold mb-1">Kelola Pengguna</h1>
    <p class="text-soil/60 text-sm mb-6">Atur peran setiap akun yang terdaftar</p>

    @if (session('success'))
        <div class="bg-padi/10 text-padi border border-padi/20 p-3 rounded-lg mb-5 text-sm">{{ session('success') }}</div>
    @endif

    <x-ui.card :padded="false" class="overflow-x-auto">
    <table class="w-full text-sm min-w-[600px]">
        <thead>
            <tr class="text-left border-b border-soil/10">
                <th class="py-3 px-4 font-medium text-soil/60">Nama</th>
                <th class="py-3 px-4 font-medium text-soil/60">Email</th>
                <th class="py-3 px-4 font-medium text-soil/60">Peran</th>
                <th class="py-3 px-4 font-medium text-soil/60">Ubah peran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr wire:key="user-{{ $user->id }}" class="border-b border-soil/10 last:border-0">
                    <td class="py-3 px-4 whitespace-nowrap">{{ $user->name }}</td>
                    <td class="py-3 px-4 text-soil/60 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="py-3 px-4">
                        @if ($user->roles->isNotEmpty())
                            <span class="text-xs font-medium bg-clay/10 text-clay px-2 py-0.5 rounded-full whitespace-nowrap">
                                {{ $user->roles->pluck('name')->join(', ') }}
                            </span>
                        @else
                            <span class="text-soil/30">-</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <select wire:change="assignRole({{ $user->id }}, $event.target.value)"
                            class="rounded-lg border border-soil/20 bg-white px-2.5 py-1.5 text-sm focus:border-clay focus:ring-1 focus:ring-clay outline-none">
                            <option value="">pilih</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-ui.card>
</div>
