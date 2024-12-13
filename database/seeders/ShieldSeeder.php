<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_pegawai","view_any_pegawai","create_pegawai","update_pegawai","restore_pegawai","restore_any_pegawai","replicate_pegawai","reorder_pegawai","delete_pegawai","delete_any_pegawai","force_delete_pegawai","force_delete_any_pegawai","view_pembinaankarir","view_any_pembinaankarir","create_pembinaankarir","update_pembinaankarir","restore_pembinaankarir","restore_any_pembinaankarir","replicate_pembinaankarir","reorder_pembinaankarir","delete_pembinaankarir","delete_any_pembinaankarir","force_delete_pembinaankarir","force_delete_any_pembinaankarir","view_refbagian","view_any_refbagian","create_refbagian","update_refbagian","restore_refbagian","restore_any_refbagian","replicate_refbagian","reorder_refbagian","delete_refbagian","delete_any_refbagian","force_delete_refbagian","force_delete_any_refbagian","view_refjabatan","view_any_refjabatan","create_refjabatan","update_refjabatan","restore_refjabatan","restore_any_refjabatan","replicate_refjabatan","reorder_refjabatan","delete_refjabatan","delete_any_refjabatan","force_delete_refjabatan","force_delete_any_refjabatan","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","widget_PangkatChart","widget_PendidikanChart"]},{"name":"user_biasa","guard_name":"web","permissions":["view_pegawai","view_any_pegawai","create_pegawai","update_pegawai","restore_pegawai","restore_any_pegawai","replicate_pegawai","reorder_pegawai","delete_pegawai","delete_any_pegawai","force_delete_pegawai","force_delete_any_pegawai"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
