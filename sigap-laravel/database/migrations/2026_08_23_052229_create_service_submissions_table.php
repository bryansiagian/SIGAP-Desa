<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_type_id')->constrained('service_types')->cascadeOnDelete();
            $table->foreignId('submitted_by')->constrained('users')->cascadeOnDelete();
            $table->jsonb('data'); // jawaban warga: {"nik": "...", "nama_lengkap": "..."}
            $table->jsonb('fields_snapshot')->nullable(); // salinan definisi field saat submit (untuk versioning)
            $table->unsignedInteger('current_step')->default(1);
            $table->string('status')->default('diajukan'); // diajukan / diproses / selesai / ditolak
            $table->string('nomor_surat')->nullable()->unique();
            $table->timestamps();

            $table->index('service_type_id');
            $table->index('submitted_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_submissions');
    }
};
