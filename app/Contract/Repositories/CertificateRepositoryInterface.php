<?php

namespace App\Contract\Repositories;

interface CertificateRepositoryInterface extends RepositoryInterface
{
    /**
     * Create a new certificate
     *
     * @param array $data
     * @return \App\Models\Certificate
     */
    public function create(array $data): \App\Models\Certificate;

    /**
     * Update an existing certificate
     *
     * @param \App\Models\Certificate $certificate
     * @param array $data
     * @return \App\Models\Certificate
     */
    public function update(\App\Models\Certificate $certificate, array $data): \App\Models\Certificate;
}
