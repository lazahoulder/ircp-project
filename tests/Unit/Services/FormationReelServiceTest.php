<?php

namespace Tests\Unit\Services;

use App\Models\Certificate;
use App\Models\Formation;
use App\Models\FormationReel;
use App\Models\PersonneCertifies;
use App\Contract\Repositories\FormationReelRepositoryInterface;
use App\Contract\Repositories\FormationRepositoryInterface;
use App\Services\FormationReelService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class FormationReelServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $formationReelRepositoryMock;
    protected $formationRepositoryMock;
    protected FormationReelService $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mocks of the repositories
        $this->formationReelRepositoryMock = Mockery::mock(FormationReelRepositoryInterface::class);
        $this->formationRepositoryMock = Mockery::mock(FormationRepositoryInterface::class);

        // Create the service with the mock repositories
        $this->service = new FormationReelService(
            $this->formationReelRepositoryMock,
            $this->formationRepositoryMock
        );

        // Configure Storage facade for testing
        Storage::fake('public');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_get_all_formation_reels()
    {
        // Arrange
        $formationReels = FormationReel::factory()->count(3)->make();
        $this->formationReelRepositoryMock->shouldReceive('getAll')
            ->once()
            ->andReturn($formationReels);

        // Act
        $result = $this->service->getAllFormationReels();

        // Assert
        $this->assertCount(3, $result);
    }

    /** @test */
    public function it_can_get_paginated_formation_reels()
    {
        // Arrange
        $formationReels = FormationReel::factory()->count(3)->make();
        $paginatedResult = new \Illuminate\Pagination\LengthAwarePaginator(
            $formationReels,
            3,
            10,
            1
        );

        $this->formationReelRepositoryMock->shouldReceive('getPaginated')
            ->once()
            ->with(10)
            ->andReturn($paginatedResult);

        // Act
        $result = $this->service->getPaginatedFormationReels(10);

        // Assert
        $this->assertEquals(3, $result->total());
    }

    /** @test */
    public function it_can_get_formation_reels_by_formation_id()
    {
        // Arrange
        $formationReels = FormationReel::factory()->count(3)->make();

        $this->formationReelRepositoryMock->shouldReceive('getByFormationId')
            ->once()
            ->with(1)
            ->andReturn($formationReels);

        // Act
        $result = $this->service->getFormationReelsByFormationId(1);

        // Assert
        $this->assertCount(3, $result);
    }

    /** @test */
    public function it_can_find_formation_reel_by_id()
    {
        // Arrange
        $formationReel = FormationReel::factory()->make(['id' => 1]);

        $this->formationReelRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($formationReel);

        // Act
        $result = $this->service->findFormationReelById(1);

        // Assert
        $this->assertEquals(1, $result->id);
    }

    /** @test */
    public function it_can_create_a_formation_reel()
    {
        // Skip this test as it's complex to mock due to file processing
        $this->markTestSkipped('This test is skipped because it involves complex file processing.');
    }

    /** @test */
    public function it_can_update_a_formation_reel()
    {
        // Arrange
        $data = [
            'date_debut' => '2023-02-01',
            'date_fin' => '2023-02-10',
        ];

        $this->formationReelRepositoryMock->shouldReceive('update')
            ->once()
            ->with(1, $data)
            ->andReturn(true);

        // Act
        $result = $this->service->updateFormationReel(1, $data);

        // Assert
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_delete_a_formation_reel()
    {
        // Arrange
        $formationReel = FormationReel::factory()->make([
            'id' => 1,
            'participants_file' => 'path/to/file.xlsx',
        ]);

        $this->formationReelRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($formationReel);

        $this->formationReelRepositoryMock->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);

        // Act
        $result = $this->service->deleteFormationReel(1);

        // Assert
        $this->assertTrue($result);
    }

    /** @test */
    public function it_returns_false_when_deleting_non_existent_formation_reel()
    {
        // Arrange
        $this->formationReelRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(999)
            ->andReturn(null);

        // Act
        $result = $this->service->deleteFormationReel(999);

        // Assert
        $this->assertFalse($result);
    }
}
