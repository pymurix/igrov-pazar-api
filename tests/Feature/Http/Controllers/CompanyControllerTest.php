<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = $this->createUser([User::ROLE_ADMIN]);
    }

    public function test_index(): void
    {
        $companies = Company::factory()->count(10)->create();

        $response = $this->get('/api/companies');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5, 'data')
            ->assertJson([
                'data' => $companies->take(5)->toArray(),
            ]);;
    }

    public function test_store(): void
    {
        $companyData = Company::factory()->make()->toArray();

        $response = $this
            ->actingAs($this->adminUser)
            ->post('/api/companies', $companyData);

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
        $companyUpdateData = Company::factory()
            ->make()
            ->toArray();

        $response = $this
            ->actingAs($this->adminUser)
            ->put('/api/companies/' . $company->id, $companyUpdateData);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('companies', $companyUpdateData);
    }

    public function test_destroy(): void
    {
        $company = Company::factory()->create();

        $response = $this
            ->actingAs($this->adminUser)
            ->delete('/api/companies/' . $company->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
        ]);
    }
}
