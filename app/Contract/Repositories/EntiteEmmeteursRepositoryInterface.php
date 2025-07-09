<?php

namespace App\Contract\Repositories;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Pagination\Paginator;

interface EntiteEmmeteursRepositoryInterface extends RepositoryInterface
{
    public function searchValide(string $search = ''): Paginator;

    public function getQuantityByStatus(mixed $status);
}
