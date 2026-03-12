<?php

namespace App\Modules\Customer\Repositories;

use App\Modules\Customer\Contracts\ICustomerRepository;
use App\Modules\Customer\Models\Customer;

class EloquentCustomerRepository implements ICustomerRepository
{
    public function firstOrCreate(string $email, string $phone, string $name): Customer
    {
        // Ищем по email ИЛИ phone (приоритет email)
        return Customer::firstOrCreate(
            ['email' => $email],
            ['phone' => $phone, 'name' => $name]
        );
    }
}
