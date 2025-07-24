<?php

namespace App\Contract\Repositories;

use App\Models\Certificate;
use App\Repositories\CertificateRepository;
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
}
