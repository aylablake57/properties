<?php

namespace Database\Seeders;

use App\Models\PropertySubType;
use App\Models\PropertyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySubTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propertySubTypes = [
            'House' => ['House', 'Flat', 'Farm House'],
            'Commercial' => ['Shop', 'Office', 'Warehouse', 'Factory', 'Building', 'Other'],
            'Plot' => ['Plot Form', 'File','Industrial Land','Agricultural Land','Commercial Land','Residential Plot'],
        ];
        foreach ($propertySubTypes as $propertyType => $subTypes) {
            $propertyType = PropertyType::where('name', $propertyType)->first();
            foreach ($subTypes as $subType) {
                PropertySubType::create([
                    'type_id' => $propertyType->id,
                    'name' => $subType,
                ]);
            }
        }
    }
}
