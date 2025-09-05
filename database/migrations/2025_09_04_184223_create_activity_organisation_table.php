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
        Schema::create('activity_organisation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisation_id')
                ->references('id')
                ->on('organisations')
                ->onDelete('cascade');
            $table->foreignId('activity_id')
                ->references('id')
                ->on('activities')
                ->onDelete('cascade');
            $table->unique(['organisation_id', 'activity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_organisation');
    }
};
