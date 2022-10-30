<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(2)->create();
        \App\Models\Course::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Rafael Barrios',
            'email' => 'rdbarrios20@gmail.com',
            'phone' => '3004158084',
            'password' => bcrypt('secret'),
        ]);

        $this->call([
            RolSeeder::class
        ]);

    }
}
