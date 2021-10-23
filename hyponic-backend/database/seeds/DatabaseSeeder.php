<?php

use App\Growth;
use App\Plant;
use App\User;
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
        // $this->call(UserSeeder::class);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@hyponic.com',
            'password' => bcrypt('Dadang123456'),
            'role' => 'ADMIN'
        ]);

        Plant::create([
            'name' => 'Brambang',
            'user_id' => 1
        ]);

        Plant::create([
            'name' => 'Bombay',
            'user_id' => 1
        ]);
    }
}
