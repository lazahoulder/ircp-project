<?php

namespace Tests\Unit\Repositories;

use App\Models\Formation;
use App\Repositories\FormationRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormationRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected FormationRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new FormationRepository(new Formation());
    }

    /** @test */
    public function it_can_get_all_formations()
    {
        // Arrange
        Formation::factory()->count(3)->create();

        // Act
        $formations = $this->repository->getAll();

        // Assert
        $this->assertCount(3, $formations);
    }

    /** @test */
    public function it_can_get_paginated_formations()
    {
        // Arrange
        Formation::factory()->count(15)->create();

        // Act
        $formations = $this->repository->getPaginated(10);

        // Assert
        $this->assertEquals(10, $formations->perPage());
        $this->assertEquals(15, $formations->total());
    }

    /** @test */
    public function it_can_get_formations_by_entity_id()
    {
        // Arrange
        Formation::factory()->count(3)->create(['entite_emmeteur_id' => 1]);
        Formation::factory()->count(2)->create(['entite_emmeteur_id' => 2]);

        // Act
        $formations = $this->repository->getByEntityId(1);

        // Assert
        $this->assertEquals(3, $formations->total());
    }

    /** @test */
    public function it_can_search_formations()
    {
        // Arrange
        Formation::factory()->create(['titre' => 'Test Formation', 'entite_emmeteur_id' => 1]);
        Formation::factory()->create(['titre' => 'Another Formation', 'entite_emmeteur_id' => 1]);
        Formation::factory()->create(['description' => 'Test Description', 'entite_emmeteur_id' => 2]);

        // Act
        $formations = $this->repository->search('Test', 1);

        // Assert
        $this->assertEquals(1, $formations->total());
        $this->assertEquals('Test Formation', $formations->first()->titre);
    }

    /** @test */
    public function it_can_find_formation_by_id()
    {
        // Arrange
        $formation = Formation::factory()->create();

        // Act
        $foundFormation = $this->repository->findById($formation->id);

        // Assert
        $this->assertEquals($formation->id, $foundFormation->id);
    }

    /** @test */
    public function it_can_create_a_formation()
    {
        // Arrange
        $data = [
            'titre' => 'New Formation',
            'description' => 'Formation Description',
            'entite_emmeteur_id' => 1,
            'expiration_year' => 5,
        ];

        // Act
        $formation = $this->repository->create($data);

        // Assert
        $this->assertDatabaseHas('formations', $data);
        $this->assertEquals('New Formation', $formation->titre);
    }

    /** @test */
    public function it_can_update_a_formation()
    {
        // Arrange
        $formation = Formation::factory()->create();
        $data = [
            'titre' => 'Updated Formation',
            'description' => 'Updated Description',
        ];

        // Act
        $result = $this->repository->update($formation->id, $data);

        // Assert
        $this->assertTrue($result);
        $this->assertDatabaseHas('formations', [
            'id' => $formation->id,
            'titre' => 'Updated Formation',
            'description' => 'Updated Description',
        ]);
    }

    /** @test */
    public function it_can_delete_a_formation()
    {
        // Arrange
        $formation = Formation::factory()->create();

        // Act
        $result = $this->repository->delete($formation->id);

        // Assert
        $this->assertTrue($result);
        $this->assertDatabaseMissing('formations', ['id' => $formation->id]);
    }
}
