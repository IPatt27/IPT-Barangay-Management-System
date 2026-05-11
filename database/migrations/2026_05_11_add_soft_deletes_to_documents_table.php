<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds the `deleted_at` column required by Laravel's SoftDeletes trait.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->softDeletes(); // adds nullable `deleted_at` timestamp column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};