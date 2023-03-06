<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
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
            ->assertJsonCount(Company::RECORDS_PER_PAGE, 'data')
            ->assertJson([
                'data' => $companies->take(Company::RECORDS_PER_PAGE)->toArray(),
            ]);;
    }

    public function test_index_with_filter_and_sort()
    {
        $dataToAssert = new Collection([
            Company::factory()->create(['name' => 'joz'])->toArray(),
            Company::factory()->create(['name' => 'job'])->toArray(),
            Company::factory()->create(['name' => 'joa'])->toArray(),
            Company::factory()->create(['name' => 'joc'])->toArray(),
        ]);
        Company::factory()->create(['name' => 'jqqq']);
        $sorted = $dataToAssert->sortByDesc('name');

        $query = http_build_query(['filter' => ['name' => ['like' => '%jo%']], 'sort' => ['name' => 'desc']]);
        $response = $this->get('/api/companies?' . $query);

        $response->assertJsonCount(4, 'data')
            ->assertJsonFragment(['data' => $sorted->toArray()]);
    }

    public function test_store(): void
    {
        $companyData = Company::factory()->make()->toArray();

        $response = $this
            ->actingAs($this->adminUser)
            ->post('/api/companies', $companyData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment($companyData);
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
