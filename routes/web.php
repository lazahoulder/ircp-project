<?php

use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('site.welcome');
})->name('home');

Route::get('/search', function ($id = null) {
    return view('site.recherche', ['id' => $id]);
})->name('search');

Volt::route('/search/{id}', 'certificate-details')->name('search.details');

Route::get('/centres', function () {
    return view('site.centres');
})->name('centres');

Volt::route('/centres/{id}', 'center-details')->name('centre.details');

Route::get('/about', function () {
    return view('site.about');
})->name('about');

Route::get('/contact', function () {
    return view('site.contact');
})->name('contact');

Route::get('/download-certificate/{id}', [CertificateController::class, 'download'])
    ->name('certificate.download');

/*Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');*/

Route::middleware(['auth'])->prefix('platform-admin')->group(function () {
    Route::redirect('', 'dashboard');

    Route::view('dashboard', 'dashboard')
        ->name('admin.dashboard');

    Volt::route('etablissements', 'etablissement.gestion-etablissement')->name('admin.etablissements');;
    Volt::route('etablissements/{id}}', 'admin.etablissement.detail-etablissement')->name('admin.etablissements-details');
    Route::get(
        'formations-reel/export-certificate/{formationReelId?}',
        [CertificateController::class, 'downloadExcel'])
        ->name('admin.certificates.export');

});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth', 'verified'])->prefix('mon-compte')->group(function () {
    Route::redirect('', 'mon-etablissement');
    Volt::route('profile', 'mysetting.my-profile')->name('moncompte.profile');
//    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('password', 'mysetting.password')->name('moncompte.password');
    Volt::route('mon-etablissement', 'mysetting.mon-etablissement')->name('moncompte.etablissement');
    Volt::route('formations', 'mysetting.user-formations')->name('moncompte.formations');
});


require __DIR__ . '/auth.php';
