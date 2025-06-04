<?php

namespace Tests\Unit\Repositories;

use App\Models\Certificate;
use App\Models\Formation;
use App\Models\FormationReel;
use App\Repositories\FormationReelRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormationReelRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected FormationReelRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new FormationReelRepository(new FormationReel(), new Certificate());
    }

    /** @test */
    public function it_can_get_all_formation_reels()
    {
        // Arrange
        FormationReel::factory()->count(3)->create();

        // Act
        $formationReels = $this->repository->getAll();

        // Assert
        $this->assertCount(3, $formationReels);
    }

    /** @test */
    public function it_can_get_paginated_formation_reels()
    {
        // Arrange
        FormationReel::factory()->count(15)->create();

        // Act
        $formationReels = $this->repository->getPaginated(10);

        // Assert
        $this->assertEquals(10, $formationReels->perPage());
        $this->assertEquals(15, $formationReels->total());
    }

    /** @test */
    public function it_can_get_formation_reels_by_formation_id()
    {
        // Arrange
        $formation1 = Formation::factory()->create();
        $formation2 = Formation::factory()->create();

        FormationReel::factory()->count(3)->create(['formation_id' => $formation1->id]);
        FormationReel::factory()->count(2)->create(['formation_id' => $formation2->id]);

        // Act
        $formationReels = $this->repository->getByFormationId($formation1->id);

        // Assert
        $this->assertCount(3, $formationReels);
    }

    /** @test */
    public function it_can_find_formation_reel_by_id()
    {
        // Arrange
        $formationReel = FormationReel::factory()->create();

        // Act
        $foundFormationReel = $this->repository->findById($formationReel->id);

        // Assert
        $this->assertEquals($formationReel->id, $foundFormationReel->id);
    }

    /** @test */
    public function it_can_create_a_formation_reel()
    {
        // Arrange
        $formation = Formation::factory()->create();
        $data = [
            'formation_id' => $formation->id,
            'date_debut' => '2023-01-01',
            'date_fin' => '2023-01-10',
            'participants_file' => 'path/to/file.xlsx',
        ];

        // Act
        $formationReel = $this->repository->create($data);

        // Assert
        $this->assertDatabaseHas('formation_reels', $data);
        $this->assertEquals($formation->id, $formationReel->formation_id);
    }

    /** @test */
    public function it_can_update_a_formation_reel()
    {
        // Arrange
        $formationReel = FormationReel::factory()->create();
        $data = [
            'date_debut' => '2023-02-01',
            'date_fin' => '2023-02-10',
        ];

        // Act
        $result = $this->repository->update($formationReel->id, $data);

        // Assert
        $this->assertTrue($result);
        $this->assertDatabaseHas('formation_reels', [
            'id' => $formationReel->id,
            'date_debut' => '2023-02-01',
            'date_fin' => '2023-02-10',
        ]);
    }

    /** @test */
    public function it_can_delete_a_formation_reel()
    {
        // Arrange
        $formationReel = FormationReel::factory()->create();

        // Act
        $result = $this->repository->delete($formationReel->id);

        // Assert
        $this->assertTrue($result);
        $this->assertDatabaseMissing('formation_reels', ['id' => $formationReel->id]);
    }

    /** @test */
    public function it_can_count_certificates_for_formation_in_year()
    {
        // Arrange
        $formation = Formation::factory()->create();
        $formationReel = FormationReel::factory()->create([
            'formation_id' => $formation->id,
            'date_fin' => '2023-05-15',
        ]);

        // Create certificates for this formation reel
        Certificate::factory()->count(5)->create([
            'formation_reel_id' => $formationReel->id,
        ]);

        // Act
        $count = $this->repository->countCertificatesForFormationInYear($formation->id, 2023);

        // Assert
        $this->assertEquals(5, $count);
    }
}
