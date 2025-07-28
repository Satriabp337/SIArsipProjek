<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('user'); // Add back static role
        $table->dropForeign(['role_id']); // Optional: if foreign key exists
        $table->dropColumn('role_id');    // Optional: remove role_id
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
        $table->unsignedBigInteger('role_id')->nullable();
        $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
    });
}
};
