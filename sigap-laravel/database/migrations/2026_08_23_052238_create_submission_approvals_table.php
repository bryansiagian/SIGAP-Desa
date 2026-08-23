<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('service_submissions')->cascadeOnDelete();
            $table->foreignId('step_id')->constrained('service_approval_steps')->cascadeOnDelete();
            $table->foreignId('approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('menunggu'); // menunggu / disetujui / ditolak
            $table->text('catatan')->nullable();
            $table->timestamp('waktu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_approvals');
    }
};
