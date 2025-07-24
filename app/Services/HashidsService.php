<?php

namespace App\Services;

class HashidsService
{
    protected $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids(env('HASHIDS_SALT', 'votre-cle-secrete'), 8);
    }

    public function encode($id)
    {
        return $this->hashids->encode($id);
    }

    public function decode($hash)
    {
        $decoded = $this->hashids->decode($hash);
        return $decoded ? $decoded[0] : null;
    }
}
