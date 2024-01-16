<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\GetClientsRequest;
use App\Services\ClientService;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends BaseController
{
    private ClientService $clientService;
    private CompanyService $companyService;

    /**
     * Create a new CompanyController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->clientService = new ClientService();
        $this->companyService = new CompanyService();
    }

    /**
     * Handles the GET /clients request
     *
     * @param GetClientsRequest $request
     * @return JsonResponse
     */
    public function index(GetClientsRequest $request): JsonResponse
    {
        try {
            // Fetch the company for the authenticated user & check if it is returned
            $company = $this->companyService->getCompanyByIdForUser($request->query('companyId'), $request->user());
            if (!$company) {
                return $this->sendError(404, 'Company not found');
            }

            // Fetch all the clients for the company
            $clients = $this->clientService->getClientsForCompany($company);

            // Return the companies
            return $this->sendResponse(200, ['clients' => $clients]);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
