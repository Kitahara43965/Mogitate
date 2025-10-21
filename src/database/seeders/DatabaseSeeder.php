<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(ProductsTableSeeder::class);
    }
}
