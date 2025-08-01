<?php

namespace App\Contract\Repositories;

interface PersonneCertifieRepositoryInterface extends RepositoryInterface
{

    public function create(array $data);

    public function upCreate(array $data, array $conditions = []);
}
