<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id(); // Kolom ID
            $table->unsignedBigInteger('user_id'); // Kolom untuk ID pengguna
            $table->string('username'); // Kolom untuk username
            $table->string('email'); // Kolom untuk email
            $table->string('action'); // Kolom untuk tindakan yang dilakukan
            $table->text('detail')->nullable(); // Kolom untuk detail tindakan
            $table->timestamps(); // Kolom untuk created_at dan updated_at

            // Menambahkan foreign key constraint jika diperlukan
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audits');
    }
}

