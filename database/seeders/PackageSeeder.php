<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $package = [
            [
                'name'          =>  'Normal' ,
                'description'   =>  'Post an ad for 30 days in normal listing.' ,
                'days'          =>  30 ,
                'price'         =>  3000
            ],
            [
                'name'          =>  'Premium' ,
                'description'   =>  'Post an ad for 30 days in above the normal listing.' ,
                'days'          =>  30 ,
                'price'         =>  6000
            ],
            [
                'name'          =>  'Featured' ,
                'description'   =>  'Post an ad for 30 days in featured listing at the top of search results.' ,
                'days'          =>  30 ,
                'price'         =>  10000
            ],
        ];

        DB::table('packages')->truncate();

        foreach($package as $p) {
            $package                =   new Package();
            $package->name          =   $p['name'];
            $package->description   =   $p['description'];
            $package->no_of_days    =   $p['days'];
            $package->price         =   $p['price'];
            $package->save();
        }
    }
}
