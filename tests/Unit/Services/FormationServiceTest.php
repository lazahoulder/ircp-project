<?php

namespace Tests\Unit\Services;

use App\Models\Formation;
use App\Contract\Repositories\FormationRepositoryInterface;
use App\Services\FormationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class FormationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $formationRepositoryMock;
    protected FormationService $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock of the repository
        $this->formationRepositoryMock = Mockery::mock(FormationRepositoryInterface::class);

        // Create the service with the mock repository
        $this->service = new FormationService($this->formationRepositoryMock);

        // Configure Storage facade for testing
        Storage::fake('public');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_get_all_formations()
    {
        // Arrange
        $formations = Formation::factory()->count(3)->make();
        $this->formationRepositoryMock->shouldReceive('getAll')
            ->once()
            ->andReturn($formations);

        // Act
        $result = $this->service->getAllFormations();

        // Assert
        $this->assertCount(3, $result);
    }

    /** @test */
    public function it_can_get_paginated_formations()
    {
        // Arrange
        $formations = Formation::factory()->count(3)->make();
        $paginatedResult = new \Illuminate\Pagination\LengthAwarePaginator(
            $formations,
            3,
            10,
            1
        );

        $this->formationRepositoryMock->shouldReceive('getPaginated')
            ->once()
            ->with(10)
            ->andReturn($paginatedResult);

        // Act
        $result = $this->service->getPaginatedFormations(10);

        // Assert
        $this->assertEquals(3, $result->total());
    }

    /** @test */
    public function it_can_get_formations_by_entity_id()
    {
        // Arrange
        $formations = Formation::factory()->count(3)->make();
        $paginatedResult = new \Illuminate\Pagination\LengthAwarePaginator(
            $formations,
            3,
            10,
            1
        );

        $this->formationRepositoryMock->shouldReceive('getByEntityId')
            ->once()
            ->with(1, 10)
            ->andReturn($paginatedResult);

        // Act
        $result = $this->service->getFormationsByEntityId(1, 10);

        // Assert
        $this->assertEquals(3, $result->total());
    }

    /** @test */
    public function it_can_search_formations()
    {
        // Arrange
        $formations = Formation::factory()->count(1)->make();
        $paginatedResult = new \Illuminate\Pagination\LengthAwarePaginator(
            $formations,
            1,
            10,
            1
        );

        $this->formationRepositoryMock->shouldReceive('search')
            ->once()
            ->with('Test', 1, 10)
            ->andReturn($paginatedResult);

        // Act
        $result = $this->service->searchFormations('Test', 1, 10);

        // Assert
        $this->assertEquals(1, $result->total());
    }

    /** @test */
    public function it_can_find_formation_by_id()
    {
        // Arrange
        $formation = Formation::factory()->make(['id' => 1]);

        $this->formationRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($formation);

        // Act
        $result = $this->service->findFormationById(1);

        // Assert
        $this->assertEquals(1, $result->id);
    }

    /** @test */
    public function it_can_create_a_formation_without_certificate_file()
    {
        // Arrange
        $data = [
            'titre' => 'New Formation',
            'description' => 'Formation Description',
            'entite_emmeteur_id' => 1,
            'expiration_year' => 5,
        ];

        $formation = new Formation($data);
        $formation->id = 1;

        $this->formationRepositoryMock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($formation);

        // Act
        $result = $this->service->createFormation($data);

        // Assert
        $this->assertEquals(1, $result->id);
        $this->assertEquals('New Formation', $result->titre);
    }

    /** @test */
    public function it_can_create_a_formation_with_certificate_file()
    {
        // Arrange
        $data = [
            'titre' => 'New Formation',
            'description' => 'Formation Description',
            'entite_emmeteur_id' => 1,
            'expiration_year' => 5,
        ];

        $file = UploadedFile::fake()->create('certificate.docx', 100);

        $formation = new Formation($data);
        $formation->id = 1;

        $this->formationRepositoryMock->shouldReceive('create')
            ->once()
            ->andReturnUsing(function ($receivedData) use ($formation) {
                // Check that the modele_certificat field is set
                $this->assertArrayHasKey('modele_certificat', $receivedData);
                $this->assertStringStartsWith('certificats/', $receivedData['modele_certificat']);

                return $formation;
            });

        // Act
        $result = $this->service->createFormation($data, $file);

        // Assert
        $this->assertEquals(1, $result->id);
    }

    /** @test */
    public function it_can_update_a_formation()
    {
        // Arrange
        $data = [
            'titre' => 'Updated Formation',
            'description' => 'Updated Description',
        ];

        $formation = Formation::factory()->make([
            'id' => 1,
            'modele_certificat' => null,
        ]);

        $this->formationRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($formation);

        $this->formationRepositoryMock->shouldReceive('update')
            ->once()
            ->with(1, $data)
            ->andReturn(true);

        // Act
        $result = $this->service->updateFormation(1, $data);

        // Assert
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_delete_a_formation()
    {
        // Arrange
        $formation = Formation::factory()->make([
            'id' => 1,
            'modele_certificat' => null,
        ]);

        $this->formationRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($formation);

        $this->formationRepositoryMock->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);

        // Act
        $result = $this->service->deleteFormation(1);

        // Assert
        $this->assertTrue($result);
    }
}
