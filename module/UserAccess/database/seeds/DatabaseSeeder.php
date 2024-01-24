<?php

namespace Module\UserAccess\Database\Seeds;
use Module\UserAccess\database\seeds\ModuleTableSeeder;
use Module\UserAccess\database\seeds\SubmoduleTableSeeder;
use Module\UserAccess\database\seeds\ParentPermissionTableSeeder;
use Module\UserAccess\database\seeds\PermissionTableSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ModuleTableSeeder::class,
            SubmoduleTableSeeder::class,
            ParentPermissionTableSeeder::class,
            PermissionTableSeeder::class,
        ]);
    }
}
