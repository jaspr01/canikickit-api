<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class ClientService
{
    public function getClientsForCompany(Company $company): Collection
    {
        return $company->clients;
    }
}
