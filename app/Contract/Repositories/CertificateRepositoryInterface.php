<?php

namespace App\Contract\Repositories;

use App\Constant\CertificateConstant;
use App\Models\Certificate;
use App\Repositories\CertificateRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

interface CertificateRepositoryInterface extends RepositoryInterface
{
    /**
     * Create a new certificate
     *
     * @param array $data
     * @return Certificate
     */
    public function create(array $data): Certificate;

    /**
     * Update an existing certificate
     *
     * @param Certificate $certificate
     * @param array $data
     * @return Certificate
     */
    public function update(Certificate $certificate, array $data): Certificate;

    public function searchByFormationReelId(string $search = '', ?int $formationReelId = null): LengthAwarePaginator;

    public function searchValide(string $search = ''): Paginator;

    public function searchByStatus(string $search = '', ?string $status = null): Paginator;

    public function searchForAdmin(string $search, ?int $entiteId, ?int $formationId, ?string $status = null);

    public function upCreate(array $data, array $conditions = []);
}
