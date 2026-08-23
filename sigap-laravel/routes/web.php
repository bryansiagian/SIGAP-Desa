<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Bisa diakses siapa saja — warga lihat layanan sebelum login
Route::get('/layanan/{serviceType:key}', \App\Livewire\Warga\ServiceSubmissionForm::class)
    ->name('service.submit');

Route::middleware(['auth'])->group(function () {
    // Warga
    Route::get('/pengajuan-saya', \App\Livewire\Warga\MySubmissions::class)
        ->name('submissions.mine');

    // Staf & Admin
    Route::get('/admin/layanan', \App\Livewire\Admin\ServiceBuilder::class)
        ->middleware('role:admin|staf')->name('admin.services');

    // Staf, Admin & Verifikator
    Route::get('/admin/submissions', \App\Livewire\Admin\SubmissionList::class)
        ->middleware('role:admin|staf|verifikator')->name('admin.submissions');

    // Admin saja
    Route::get('/admin/users', \App\Livewire\Admin\UserManagement::class)
        ->middleware('role:admin')->name('admin.users');
});
