<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; 

class InsertCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
      $data = [
        ['name' => 'category 1'],
        ['name' => 'category 2'],
        ['name' => 'category 3'],
        ['name' => 'category 4'],
    ];
        Category::insert($data);
    }
}
