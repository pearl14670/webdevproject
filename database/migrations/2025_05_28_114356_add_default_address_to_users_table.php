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
        Schema::table('users', function (Blueprint $table) {
            $table->json('default_address')->nullable();
            $table->string('default_city')->nullable();
            $table->string('default_state')->nullable();
            $table->string('default_postal_code')->nullable();
            $table->string('default_country', 2)->nullable();
            $table->string('default_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'default_address',
                'default_city',
                'default_state',
                'default_postal_code',
                'default_country',
                'default_phone'
            ]);
        });
    }
};
