<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_male');
            $table->date('birth_date')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('available')->default(true);
            $table->foreignId('animal_id')->constrained('animals');
            $table->foreignId('adoption_id')->nullable()->constrained('adoptions');
            $table->foreignId('primary-picture')->nullable()->constrained('pet_pictures');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
