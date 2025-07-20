<?php

namespace App\Services;

use App\Contract\Repositories\PersonneCertifieRepositoryInterface;
use App\Models\PersonneCertifies;

class PersonneCertifieService
{
    public function __construct(private PersonneCertifieRepositoryInterface $repository)
    {

    }

    public function upCreate(array $data, $conditions = []): PersonneCertifies
    {
        try {

            return $this->repository->upCreate($conditions, $data);
        } catch (\Exception $e) {
            logger($e);
            throw $e;
        }
    }

    public function addPhoto(PersonneCertifies $personneCertifies, int $imageId)
    {
        if (!$personneCertifies->image) {
            $personneCertifies->image_id = $imageId;
            $personneCertifies->save();
        }

        return $personneCertifies;
    }
}
