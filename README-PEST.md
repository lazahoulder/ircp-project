# Guide d'utilisation de Pest PHP dans votre projet Laravel Sail

## Introduction

Pest PHP est un framework de test élégant pour PHP qui simplifie l'écriture des tests. Ce guide vous aidera à comprendre comment utiliser Pest dans votre projet Laravel.

## Installation

Pest a été installé dans votre projet avec les commandes suivantes :

```bash
./vendor/bin/sail composer require pestphp/pest:^3.8.2 phpunit/phpunit:11.5.15 --dev
./vendor/bin/sail php ./vendor/bin/pest --init
```

## Exécution des tests

Pour exécuter tous vos tests avec Pest :

```bash
./vendor/bin/sail php ./vendor/bin/pest
```

Pour exécuter un fichier de test spécifique :

```bash
./vendor/bin/sail php ./vendor/bin/pest tests/Feature/ExampleTest.php
```

## Écriture des tests avec Pest

### Structure de base d'un test Pest

```php
<?php

it('fait quelque chose', function () {
    // Votre test ici
    $result = true;
    
    expect($result)->toBeTrue();
});
```

### Utilisation des traits et des helpers

Pour utiliser des traits comme RefreshDatabase :

```php
<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('interagit avec la base de données', function () {
    // Votre test ici
});
```

### Tests de Livewire avec Pest

```php
<?php

use App\Livewire\MonComposant;
use Livewire\Livewire;

it('rend le composant avec succès', function () {
    Livewire::test(MonComposant::class)
        ->assertStatus(200);
});

it('met à jour une valeur', function () {
    Livewire::test(MonComposant::class)
        ->set('propriete', 'nouvelle valeur')
        ->assertSet('propriete', 'nouvelle valeur');
});
```

## Conversion des tests PHPUnit existants vers Pest

### Exemple de conversion

#### Avant (PHPUnit) :

```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
```

#### Après (Pest) :

```php
<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
```

## Fonctionnalités avancées

### Grouper des tests

```php
<?php

describe('Groupe de fonctionnalités', function () {
    it('fait une chose', function () {
        // Test
    });

    it('fait une autre chose', function () {
        // Test
    });
});
```

### Expectations personnalisées

Dans votre fichier `tests/Pest.php`, vous pouvez ajouter des expectations personnalisées :

```php
expect()->extend('toBePositive', function () {
    return $this->toBeGreaterThan(0);
});

// Utilisation
it('a une valeur positive', function () {
    expect(5)->toBePositive();
});
```

### Datasets

```php
<?php

it('multiplie les nombres correctement', function ($a, $b, $expected) {
    expect($a * $b)->toBe($expected);
})->with([
    [2, 2, 4],
    [3, 3, 9],
    [4, 4, 16],
]);
```

## Documentation officielle

Pour plus d'informations, consultez la [documentation officielle de Pest](https://pestphp.com/docs).
