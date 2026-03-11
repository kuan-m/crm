<?php

namespace App\Modules\Customer\Contracts;

use App\Modules\Customer\Models\Customer;

interface ICustomerRepository
{
    public function firstOrCreate(string $email, string $phone, string $name): Customer;
}
