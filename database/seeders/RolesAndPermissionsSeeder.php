<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Item permissions
            'view items', 'create items', 'edit items', 'delete items',
            // Borrowing permissions
            'view borrowings', 'create borrowings', 'approve borrowings', 'manage borrowings',
            // Module permissions
            'view modules', 'create modules', 'edit modules', 'delete modules',
            // User management
            'view users', 'manage users', 'assign roles',
            // Location management
            'manage locations',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Role: Mahasiswa
        $mahasiswa = Role::firstOrCreate(['name' => 'mahasiswa']);
        $mahasiswa->syncPermissions([
            'view items',
            'create borrowings',
            'view borrowings',
            'view modules',
        ]);

        // Role: Asisten Lab
        $asisten = Role::firstOrCreate(['name' => 'asisten_lab']);
        $asisten->syncPermissions([
            'view items', 'create items', 'edit items',
            'view borrowings', 'approve borrowings', 'manage borrowings',
            'view modules', 'create modules', 'edit modules',
        ]);

        // Role: PJ (Penanggung Jawab - replaces PLP and Koordinator)
        $pj = Role::firstOrCreate(['name' => 'pj']);
        $pj->syncPermissions(Permission::all());

        // Create default PJ user
        $admin = User::firstOrCreate(
            ['email' => 'pj@simalab.ac.id'],
            [
                'name'     => 'Penanggung Jawab SIMALAB',
                'password' => bcrypt('password123'),
                'status'   => 'active',
            ]
        );
        $admin->assignRole('pj');

        // Create sample asisten
        $asisten_user = User::firstOrCreate(
            ['email' => 'asisten@simalab.ac.id'],
            [
                'name'     => 'Asisten Lab Demo',
                'npm'      => '2023001',
                'password' => bcrypt('password123'),
                'status'   => 'active',
            ]
        );
        $asisten_user->assignRole('asisten_lab');

        // Create sample mahasiswa
        $mhs = User::firstOrCreate(
            ['email' => 'mahasiswa@simalab.ac.id'],
            [
                'name'     => 'Mahasiswa Demo',
                'npm'      => '2023002',
                'jurusan'  => 'Teknik Elektro',
                'prodi'    => 'S1 Teknik Elektro',
                'password' => bcrypt('password123'),
                'status'   => 'active',
            ]
        );
        $mhs->assignRole('mahasiswa');



        $this->command->info('✅ Roles, permissions, and demo users created successfully!');
    }
}
