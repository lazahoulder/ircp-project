<?php

namespace App\Contract\Repositories;

use App\Models\PersonneCertifies;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all(): Paginator;

    public function search(String $search = ''): Paginator;

    public function find(int $id): ?Model;
}
