<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['business_name' => 'Personal', 'business_type' => 'Personal'],
            ['business_name' => 'Golden Merita', 'business_type' => 'Boutique'],
            ['business_name' => 'Freelance', 'business_type' => 'Freelance'],
        ] as $business) {
            Business::query()->updateOrCreate(
                ['business_name' => $business['business_name']],
                [...$business, 'status' => 'Active']
            );
        }
    }
}
