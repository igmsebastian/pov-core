<?php

namespace Database\Seeders\Defaults;

use Database\Seeders\Companies\IsscManilaSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            IsscManilaSeeder::class,
            UserSeeder::class,
        ]);
    }
}
