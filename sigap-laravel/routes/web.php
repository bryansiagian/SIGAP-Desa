<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Halaman Umum
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Halaman Warga (Publik)
|--------------------------------------------------------------------------
| Bisa diakses tanpa login — warga boleh lihat & isi form layanan
| terlebih dahulu, baru diminta login saat submit.
*/

Route::get('/layanan/{serviceType:key}', \App\Livewire\Warga\ServiceSubmissionForm::class)
    ->name('service.submit');

Route::get('/layanan', \App\Livewire\Warga\ServiceIndex::class)
    ->name('service.index');

/*
|--------------------------------------------------------------------------
| Halaman Bawaan Breeze
|--------------------------------------------------------------------------
*/

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/profile', function () {
    return view('profile');
})->middleware(['auth'])->name('profile');

/*
|--------------------------------------------------------------------------
| Halaman Warga (Wajib Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/pengajuan-saya', \App\Livewire\Warga\MySubmissions::class)
        ->name('submissions.mine');
});

/*
|--------------------------------------------------------------------------
| Halaman Admin / Staf / Verifikator
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/layanan', \App\Livewire\Admin\ServiceBuilder::class)
            ->middleware('role:admin|staf')
            ->name('services');

        Route::get('/layanan/{serviceType}/fields', \App\Livewire\Admin\ServiceFieldManager::class)
            ->middleware('role:admin|staf')
            ->name('services.fields');

        Route::get('/submissions', \App\Livewire\Admin\SubmissionList::class)
            ->middleware('role:admin|staf|verifikator')
            ->name('submissions');

        Route::get('/users', \App\Livewire\Admin\UserManagement::class)
            ->middleware('role:admin')
            ->name('users');

        // Serve file terlampir (foto KTP/KK dll) dengan pengecekan otorisasi,
        // bukan lewat storage:link publik
        Route::get('/files/{file}', function (\App\Models\SubmissionFile $file) {
            $field = collect($file->submission->fields_snapshot)->firstWhere('field_key', $file->field_key);
            $isSensitive = $field['is_sensitive'] ?? false;
            $disk = $isSensitive ? 'local' : 'public';

            abort_unless(\Storage::disk($disk)->exists($file->stored_path), 404);

            return \Storage::disk($disk)->response($file->stored_path, $file->original_filename);
        })
            ->middleware('role:admin|staf|verifikator')
            ->name('files.show');
    });
    
require __DIR__.'/auth.php';
