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
        Schema::table('users',  function (Blueprint $table) {
            $table->string('azure_auth_id', 36)->unique()->nullable();
            $table->text('azure_access_token')->nullable();
            $table->text('azure_refresh_token')->nullable();
            $table->string('password')->nullable()->change();
            $table->string('username', 100)->unique()->nullable();
            $table->boolean('active')->default(true);
            $table->binary('avatar')->nullable();
            $table->datetime('azure_expires_timestamp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users',  function (Blueprint $table) {
            $table->dropColumn('azure_auth_id');
            $table->dropColumn('azure_access_token');
            $table->dropColumn('azure_refresh_token');
            $table->string('password')->nullable(false)->change();
            $table->dropColumn('username');
            $table->dropColumn('active');
            $table->dropColumn('avatar');
            $table->dropColumn('azure_expires_timestamp');
        });
    }
};
