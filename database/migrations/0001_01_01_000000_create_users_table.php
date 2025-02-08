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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kolom id (AUTO_INCREMENT)
            $table->string('username', 50)->unique(); // Kolom username, unique
            $table->string('password', 255); // Kolom password
            $table->string('email', 100)->unique(); // Kolom email, unique
            $table->binary('profile_picture')->nullable(); // Kolom profile_picture, nullable
            $table->text('bio')->nullable(); // Kolom bio, nullable
            $table->timestamp('created_at')->useCurrent(); // Kolom created_at, default current_timestamp
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate(); // Kolom updated_at, nullable
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
