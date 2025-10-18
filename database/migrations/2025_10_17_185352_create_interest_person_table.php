<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This creates the pivot table to link people and interests.
     */
    public function up(): void
    {
        Schema::create('interest_person', function (Blueprint $table) {
            $table->foreignId('person_id')->constrained()->onDelete('cascade');
            $table->foreignId('interest_id')->constrained()->onDelete('cascade');
            $table->primary(['person_id', 'interest_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interest_person');
    }
};
