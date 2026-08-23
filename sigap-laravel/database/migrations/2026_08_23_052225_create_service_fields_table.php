<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_type_id')->constrained('service_types')->cascadeOnDelete();
            $table->string('field_key');
            $table->string('label');
            $table->string('field_type'); // text, number, date, select, file, textarea
            $table->jsonb('options')->nullable(); // khusus field_type = select
            $table->string('validation_rule')->nullable(); // misal: "required|digits:16"
            $table->boolean('is_required')->default(false);
            $table->boolean('is_sensitive')->default(false);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->unique(['service_type_id', 'field_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_fields');
    }
};
