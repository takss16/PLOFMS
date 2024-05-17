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
            $table->unsignedBigInteger('folders_id');
            $table->foreign('folders_id')->references('id')->on('folders')->onDelete('cascade');
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
