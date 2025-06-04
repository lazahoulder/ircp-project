<?php

namespace App\Models\Trait;

use Illuminate\Support\Str;

trait HasInitialsTrait
{
    public abstract function getNames(): string;

    public function initials(): string
    {
        return Str::of($this->getNames())
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
}
