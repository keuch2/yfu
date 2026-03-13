<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pipeline_persons', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['inbound', 'outbound']);
            $table->enum('stage', ['prospect', 'applicant', 'participant', 'alumni']);
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('country');
            $table->string('program')->nullable();
            $table->string('destination')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('converted_from')->nullable();
            $table->timestamp('converted_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['type', 'stage']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pipeline_persons');
    }
};
