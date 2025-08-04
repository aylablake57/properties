<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propertyAmenities = [
            'Nearby Locations and Other Facilities' => [
                'Nearby Schools',
                'Nearby Hospitals',
                'Nearby Shopping Malls',
                'Nearby Restaurants',
                'Nearby Public Transport',
                'Other Nearby Places',
            ],
            'Other Facilites' => [
                'Maintenance Staff',
                'Security Staff',
                'Other Facilities',
            ],
        ];

        DB::table('amenities')->truncate();
        foreach ($propertyAmenities as $key => $category) {
            foreach ($category as $value) {
                $amenity = new Amenity();
                $amenity->key = $key;
                $amenity->value = $value;
                $amenity->save();
            }
        }
    }
}
