<?php

namespace Database\Seeders;

use App\Models\CategoryItem;
use Illuminate\Database\Seeder;

class CategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryItem::insert(
            [
                [
                    "category_name" => "Kamera"
                ],
                [
                    "category_name" => "Aksesoris"
                ],
                [
                    "category_name" => "Lainya"
                ]
            ]
        );
    }
}
