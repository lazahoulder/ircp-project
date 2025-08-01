<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ModeleController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('site.welcome');
})->name('home');

Route::get('/search', function ($id = null) {
    return view('site.recherche', ['id' => $id]);
})->name('search');

Volt::route('/search/certificate-details/{id}', 'certificate-details')
    ->name('search.details')
    ->middleware(['hashId'])
;

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
Route::get('/download-formation-modele', [ModeleController::class, 'downloadFormationExcelModele'])
    ->name('formation.model.download');
Route::get('/download-participants-modele', [ModeleController::class, 'downloadParticipantExcelModele'])
    ->name('participants.model.download');

/*Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');*/
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('platform-admin')->group(function () {
    Route::redirect('', 'dashboard');

    Route::view('dashboard', 'dashboard')
        ->name('admin.dashboard');

    Volt::route('etablissements', 'etablissement.gestion-etablissement')->name('admin.etablissements');;
    Volt::route('etablissements/{id}', 'admin.etablissement.detail-etablissement')
        ->name('admin.etablissements-details')
        ->middleware('hashId')
    ;
    Route::get(
        'formations-reel/export-certificate/{formationReelId?}',
        [CertificateController::class, 'downloadExcel'])
        ->name('admin.certificates.export');
    Volt::route('certificates', 'admin.certificate.list-certificate')->name('admin.certificates');
    Volt::route('certificates/{id}', 'admin.certificate.view-certificate')->name('admin.certificates-view')->middleware('hashId');
    Route::get('certificates/qr-code/{id}', [CertificateController::class, 'downloadQrCode'])->name('admin.certificates.qr-code')->middleware('hashId');
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

Route::resource('formations', FormationController::class)->middleware('bindings');


require __DIR__ . '/auth.php';
