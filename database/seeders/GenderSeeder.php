<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gender;

class GenderSeeder extends Seeder
{
    public function run(): void
    {
        $genders = [
            [
                'name' => 'Men',
                'slug' => 'men',
                'description' => 'Products designed for men',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Women',
                'slug' => 'women',
                'description' => 'Products designed for women',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Unisex',
                'slug' => 'unisex',
                'description' => 'Products suitable for all genders',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Kids',
                'slug' => 'kids',
                'description' => 'Products designed for children',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($genders as $gender) {
            Gender::updateOrCreate(
                ['slug' => $gender['slug']],
                $gender
            );
        }
    }
}
