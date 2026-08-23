<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('nama_layanan');
            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_builtin')->default(false);
            $table->string('status')->default('aktif'); // aktif / nonaktif
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_types');
    }
};
