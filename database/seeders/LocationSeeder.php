<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'DHA Islamabad' => [
                ['name' => 'Phase 1'],
                ['name' => 'Phase 2'],
                ['name' => 'Phase 3'],
                ['name' => 'Phase 4'],
                ['name' => 'Phase 5'],
                ['name' => 'Phase 6'],
                ['name' => 'Phase 7'],
                ['name' => 'Phase 8'],
            ],
            'DHA Lahore' => [
                ['name' => 'Phase 1'],
                ['name' => 'Phase 2'],
                ['name' => 'Phase 3'],
                ['name' => 'Phase 4'],
                ['name' => 'Phase 5'],
            ],
            'DHA Karachi' => [
                ['name' => 'Phase 1'],
                ['name' => 'Phase 2'],
                ['name' => 'Phase 3'],
            ],
        ];

        DB::table('cities')->truncate();
        DB::table('locations')->truncate();

        foreach ($cities as $cityName => $cityLocations) {
            $city = City::create(['name' => $cityName]);
            $city->locations()->createMany($cityLocations);
        }
    }
}
