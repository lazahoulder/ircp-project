<?php

use App\Livewire\ListCertificate;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ListCertificate::class)
        ->assertStatus(200)
        ->assertSeeLivewire('list-certificate')
        ->assertHasNoErrors()
    ;
});
