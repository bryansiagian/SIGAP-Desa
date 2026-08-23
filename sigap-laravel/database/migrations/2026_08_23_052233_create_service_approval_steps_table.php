<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_approval_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_type_id')->constrained('service_types')->cascadeOnDelete();
            $table->unsignedInteger('urutan');
            $table->string('nama_tahap'); // misal: "Verifikasi RT", "Persetujuan Kepala Desa"
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete(); // dari tabel roles milik Spatie
            $table->timestamps();

            $table->unique(['service_type_id', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_approval_steps');
    }
};
