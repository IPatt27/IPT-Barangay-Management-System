<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blotter_parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blotter_id')->constrained('blotters')->onDelete('cascade');
            $table->foreignId('resident_id')->nullable()->constrained('residents')->onDelete('set null');
            $table->string('name');                            // Full name (auto-filled if resident)
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->enum('role', ['Complainant', 'Respondent', 'Witness']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blotter_parties');
    }
};
