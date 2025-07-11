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
            $table->unsignedBigInteger('category_id');
            $table->string('sub_category')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->enum('access_level', ['Public', 'Internal', 'Confidential']);
            $table->text('description')->nullable();
            $table->string('tags')->nullable(); // comma-separated
            $table->string('filename'); // disimpan di storage
            $table->string('original_filename');
            $table->string('file_type');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();

            // Foreign key (opsional bisa pakai cascade or restrict)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
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
