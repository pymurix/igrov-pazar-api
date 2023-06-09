<?php

namespace App\Http\Controllers;

use App\Http\Data\StoreCompanyData;
use App\Http\Data\UpdateCompanyData;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        $companies = Company::filterable(request("filter", []))
            ->sortable(request('sort', []))
            ->paginate(Company::RECORDS_PER_PAGE);
        return response()->json($companies);
    }

    public function store(StoreCompanyData $request): JsonResponse
    {
        $company = Company::create($request->toArray());
        return response()->json($company, Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(Company::find($id));
    }

    public function update(UpdateCompanyData $request, int $id): JsonResponse
    {
        $updated = Company::where('id', $id)
            ->update($request->toArray());
        return response()
            ->json($updated);
    }

    public function destroy(int $id): JsonResponse
    {
        Company::where('id', $id)
            ->delete();
        return response()
            ->json(null, Response::HTTP_NO_CONTENT);
    }
}
