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
        \DB::beginTransaction();
        \App\Models\User::factory(10)->create();
        $this->call([LocationSeeder::class,EventSeeder::class]);
        \DB::commit();

    }
}
