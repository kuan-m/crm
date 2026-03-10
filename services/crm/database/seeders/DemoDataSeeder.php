<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory(10)
            ->has(Ticket::factory()->count(2))
            ->has(Ticket::factory()->inWork()->count(1))
            ->has(Ticket::factory()->processed()->count(2))
            ->create();
    }
}
