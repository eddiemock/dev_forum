<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = ['user', 'moderator', 'administrator'];

        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }
    }
}
