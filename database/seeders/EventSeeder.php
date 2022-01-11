<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
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
            $date = Carbon::now()->subDays(rand(-365, 365));
            $toInsert [] = [
                'title'=> $faker->sentence,
                'start_date'=> $date->format('Y-m-d'),
                'end_date'=>$date->addWeeks(rand(1, 52))->format('Y-m-d H:i:s'),
                'description'=>$faker->sentence,
                'location_id'=>\App\Models\Location::get()->random()->id,
                'user_id'=> \App\Models\User::get()->random()->id,
                'created_at'=>now(),
            ];
    
        }

        DB::table('events')->insert($toInsert);
    }
}
