<?php

namespace App\Services;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Company\CreateUpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ItemNotFoundException;

class CompanyService
{
    /**
     * Creates or updates a company for the given user
     *
     * @param CreateUpdateCompanyRequest $request
     * @param User $user
     * @param string|null $id
     * @return Company
     * @throws ItemNotFoundException
     */
    public function createUpdateCompanyForUser(CreateUpdateCompanyRequest $request, User $user, ?string $id = null): Company
    {
        // Fetch or create the company
        $company = $id ? $user->companies()->findOrFail($id) : new Company();

        // Fill the company with the request data
        foreach ($company->getFillable() as $key) {
            // Skip the vatNumber when updating a company (can never be updated)
            if ($key === 'vatNumber' && $id) continue;

            $company->$key = $request->$key;
        }

        // Check if we are creating a new company
        if (!$id) {
            // Save the company for the user
            $user->companies()->save($company);
        } else {
            // Update the company
            $company->save();
        }

        // Return the company
        return $company;
    }

    /**
     * @param Company $company
     * @param User $user
     * @return void
     */
    public function deleteCompanyForUser(Company $company, User $user): void
    {
        // Detach & delete the company
        $user->companies()->detach($company->id);
        $company->delete();
    }

    /**
     * Fetches all the companies for the given user
     *
     * @param User $user
     * @return Collection
     */
    public function getCompaniesForUser(User $user): Collection
    {
        // Fetch all the companies for the user
        return $user->companies;
    }

    /**
     * Fetches the company for the given user by id
     *
     * @param string $id
     * @param User $user
     * @return Company|null
     */
    public function getCompanyByIdForUser(string $id, User $user): Company | null
    {
        // Fetch & return the company for the user
        return $user->companies()->where('id', $id)->first();
    }
}
