<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Business;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $business = Business::query()->first();

        if (!$business) {
            return;
        }

        foreach ([
            ['account_name' => 'Cash', 'account_type' => 'Cash'],
            ['account_name' => 'Bank', 'account_type' => 'Bank'],
            ['account_name' => 'UPI', 'account_type' => 'UPI'],
        ] as $account) {
            Account::query()->updateOrCreate(
                ['business_id' => $business->id, 'account_name' => $account['account_name']],
                [...$account, 'notes' => 'Default seeded account']
            );
        }
    }
}
