<?php

namespace App\Services;

use Hashids\Hashids;

class HashidsService
{
    protected $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids();
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
