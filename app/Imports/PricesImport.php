<?php

namespace App\Imports;

use App\Models\Price;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PricesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Price([
            'city' => $row['city'],
            'phase' => $row['phase'],
            'sector' => $row['sector'],
            '125_yards' => $row['125_yds'],
            '133_yards' => $row['133_yds'],
            '200_yards' => $row['200_yds'],
            '250_yards' => $row['250_yds'],
            '300_yards' => $row['125_yds'],
            '400_yards' => $row['125_yds'],
            '500_yards' => $row['125_yds'],
            '800_yards' => $row['125_yds'],
            '1000_yards' => $row['125_yds'],
        ]);
    }

    public function rules(): array
    {
        return [
            'city' => 'required',
            'phase' => 'required',
            'sector' => 'required',
        ];
    }
}
