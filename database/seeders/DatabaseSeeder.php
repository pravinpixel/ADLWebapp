<?php

namespace Database\Seeders;

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
            UserAndRolesSeeder::class,
            NewsAndEventSeeder::class,
            ApiLocationSeeder::class,
            PaymentSeeder::class,
            BannerSeeder::class,
            ApiSeeder::class,
            OrganSeeder::class,
            ConditionSeeder::class,
            DepartmentSeeder::class,
            JobPostSeeder::class
        ]);
    }
}
