<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        $companies = Company::filterable(request("filter", []))
            ->sortable(request('sort', []))
            ->paginate(5);
        return response()->json($companies);
    }

    public function store(StoreCompanyRequest $request): JsonResponse
    {
        Company::create($request->validated());
        return response()->json([], Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(Company::find($id));
    }

    public function update(UpdateCompanyRequest $request, int $id): JsonResponse
    {
        $updated = Company::where('id', $id)->update($request->validated());
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
