<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // sebelum run pastikan disable dulu blameable
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            StatusSeeder::class,
            TeganganSeeder::class,
            FungsiSeeder::class,
            BmkgSeeder::class,
            LocationOneSeeder::class,
            LocationTwoSeeder::class,
            LocationThreeSeeder::class,


        ]);
    }
}
