<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blotter_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blotter_id')->constrained('blotters')->onDelete('cascade');
            $table->string('file_name');                       // Original file name
            $table->string('file_path');                       // Stored path
            $table->string('file_type')->nullable();           // MIME type
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blotter_attachments');
    }
};
