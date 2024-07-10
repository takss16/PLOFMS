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
        Schema::create('filecases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('casefolder_id'); // Add this line
            $table->foreign('casefolder_id')->references('id')->on('casefolders')->onDelete('cascade'); // Add this line
            $table->string('file_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filecases');
    }
};
