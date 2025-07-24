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
      Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('nomor_surat')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('sub_category')->nullable();
            $table->text('description')->nullable();
            $table->string('tags')->nullable(); // comma-separated
            $table->string('filename'); // disimpan di storage
            $table->string('original_filename');
            $table->string('file_type');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();

            // Foreign key (opsional bisa pakai cascade or restrict)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
