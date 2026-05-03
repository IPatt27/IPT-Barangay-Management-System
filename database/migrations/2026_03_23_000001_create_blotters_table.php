<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blotters', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();           // e.g. BLT-2026-000001
            $table->string('incident_type');                   // e.g. Noise Complaint, Physical Assault
            $table->dateTime('incident_date');
            $table->string('incident_location');
            $table->text('incident_description');
            $table->enum('status', [
                'Active',
                'Under Investigation',
                'Settled',
                'Dismissed',
                'Referred to Higher Authority',
            ])->default('Active');
            $table->string('recorded_by');                     // Name of staff who recorded it
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blotters');
    }
};
