<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CreateUpdateCompanyRequest;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{
    private CompanyService $companyService;

    /**
     * Create a new CompanyController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->companyService = new CompanyService();
    }

    /**
     * Handles the GET /companies request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Fetch all the companies for the authenticated user
            $companies = $this->companyService->getCompaniesForUser($request->user());

            // Return the companies
            return $this->sendResponse(200, ['companies' => $companies]);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }

    /**
     * Handles the POST /companies request
     *
     * @param CreateUpdateCompanyRequest $request
     * @return JsonResponse
     */
    public function store(CreateUpdateCompanyRequest $request): JsonResponse
    {
        try {
            // Create a new company for the authenticated user
            $company = $this->companyService->createUpdateCompanyForUser($request, $request->user());

            // Return the company
            return $this->sendResponse(201, ['company' => $company]);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }

    /**
     * Handles the GET /companies/{id} request
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function show(Request $request, string $id): JsonResponse
    {
        try {
            // Fetch the company for the authenticated user
            $company = $this->companyService->getCompanyByIdForUser($id, $request->user());

            // Check if the company exists
            if (!$company) {
                return $this->sendError(404, 'Company not found');
            }

            // Return the company
            return $this->sendResponse(200, ['company' => $company]);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }

    /**
     * Handles the PUT /companies/{id} request
     *
     * @param CreateUpdateCompanyRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(CreateUpdateCompanyRequest $request, string $id): JsonResponse
    {
        try {
            // Update the company for the authenticated user
            $company = $this->companyService->createUpdateCompanyForUser($request, $request->user(), $id);

            // Return the company
            return $this->sendResponse(200, ['company' => $company]);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }

    /**
     * Handles the DELETE /companies/{id} request
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        try {
            // Fetch the company for the authenticated user
            $company = $this->companyService->getCompanyByIdForUser($id, $request->user());

            // Check if the company exists
            if (!$company) {
                return $this->sendError(404, 'Company not found');
            }

            // Delete the company for the authenticated user
            $this->companyService->deleteCompanyForUser($company, $request->user());

            // Return ok
            return $this->sendResponse(200);
        } catch (\Exception $e) {
            return $this->sendError(500, $e->getMessage());
        }
    }
}
