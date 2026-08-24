<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Desa',
                'email' => 'admin@sigapdesa.test',
                'nik' => '1100000000000001',
                'no_hp' => '081200000001',
                'role' => 'admin',
            ],
            [
                'name' => 'Staf Desa',
                'email' => 'staf@sigapdesa.test',
                'nik' => '1100000000000002',
                'no_hp' => '081200000002',
                'role' => 'staf',
            ],
            [
                'name' => 'Verifikator RT',
                'email' => 'verifikator@sigapdesa.test',
                'nik' => '1100000000000003',
                'no_hp' => '081200000003',
                'role' => 'verifikator',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'warga@sigapdesa.test',
                'nik' => '1100000000000004',
                'no_hp' => '081200000004',
                'role' => 'warga',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'nik' => $data['nik'],
                    'no_hp' => $data['no_hp'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}
