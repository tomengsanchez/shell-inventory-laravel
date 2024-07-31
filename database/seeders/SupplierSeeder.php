<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Supplier::factory()->count(10)->create();
        DB::table('suppliers')->insert([
            'name' => Str::random(20),
            'address' => Str::random(50),
            'contact_number' => Str::random(11),
            
        ]);
    }
}
