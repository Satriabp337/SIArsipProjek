<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id(); // id, AUTO_INCREMENT
            $table->string('doc_name', 255);
            $table->string('user_name', 40);
            $table->unsignedInteger('user_id')->default(0);
            $table->string('user_email', 100)->default('ay.sasongko2@gmail.com');
            $table->timestamp('date')->useCurrent();
            $table->string('action', 255)->default('unknown');
            $table->string('details', 255)->nullable();
            $table->timestamps(); // created_at & updated_at with current timestamp default
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
