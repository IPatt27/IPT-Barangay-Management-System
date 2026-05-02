<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('owner_name');
            $table->string('business_type');
            $table->string('address');
            $table->string('contact_number');
            $table->string('permit_number')->unique();
            $table->string('reference_number')->unique();
            $table->date('issued_date');
            $table->date('expiry_date');
            $table->string('status'); // Active, Expired, Revoked
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};