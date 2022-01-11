<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $toInsert = [];
        
        foreach(range(1,100) as $i){
            $toInsert [] = [
                'name'=> $faker->name,
                'latitude'=>$faker->latitude(),
                'longitude'=>$faker->longitude(),
                'created_at'=>now(),
            ];
        }

        DB::table('locations')->insert($toInsert);
    }
}
