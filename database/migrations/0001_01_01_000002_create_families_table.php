<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->string('contact');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->unsignedTinyInteger('capacity')->default(1);
            $table->enum('status', ['Disponible', 'Ocupada'])->default('Disponible');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
