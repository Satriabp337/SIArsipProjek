<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Tambah kolom role_id
            $table->unsignedBigInteger('role_id')->nullable()->after('id');
        });

        // 2. Isi nilai role_id dari kolom role (string)
        $roles = DB::table('roles')->pluck('id', 'name');
        DB::table('users')->get()->each(function ($user) use ($roles) {
            $rid = $roles[$user->role] ?? null;
            DB::table('users')
                ->where('id', $user->id)
                ->update(['role_id' => $rid]);
        });

        Schema::table('users', function (Blueprint $table) {
            // 3. Buat not-null & foreign key
            $table->unsignedBigInteger('role_id')->nullable(false)->change();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            // 4. Hapus kolom role lama
            $table->dropColumn('role');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Balikkan perubahan
            $table->string('role')->default('user')->after('id');
        });

        $roles = DB::table('roles')->pluck('name', 'id');
        DB::table('users')->get()->each(function ($user) use ($roles) {
            $name = $roles[$user->role_id] ?? 'user';
            DB::table('users')
                ->where('id', $user->id)
                ->update(['role' => $name]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};