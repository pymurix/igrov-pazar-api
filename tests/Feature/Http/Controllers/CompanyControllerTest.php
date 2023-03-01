<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index(): void
    {
        Company::factory()->count(10)->create();

        $response = $this->get('/api/companies');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonCount(5, 'data');
    }

    public function test_store(): void
    {
        $companyData = Company::factory()->make()->toArray();

        $response = $this->post('/api/companies', $companyData);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('companies', $companyData);
    }

    public function test_show(): void
    {
        $company = Company::factory()->create();

        $response = $this->get('/api/companies/' . $company->id);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'id' => $company->id,
            'name' => $company->name,
        ]);
    }

    public function test_update(): void
    {
        $company = Company::factory()->create();

        $companyData = Company::factory()
            ->make()
            ->toArray();

        $response = $this->put('/api/companies/' . $company->id, $companyData);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('companies', $companyData);
    }

    public function test_destroy(): void
    {
        $company = Company::factory()->create();

        $response = $this->delete('/api/companies/' . $company->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
        ]);
    }
}
