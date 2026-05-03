<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
            $table->enum('document_type', [
                'Barangay Clearance',
                'Certificate of Residency',
                'Certificate of Indigency',
                'Good Moral Character',
                'Business Clearance',
            ]);
            $table->string('purpose');
            $table->string('or_number')->nullable();      // Official Receipt number
            $table->string('issued_by')->nullable();      // Name of signing official
            $table->string('position')->nullable();       // e.g. "Barangay Captain"
            $table->string('status')->default('Issued');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
