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
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('id')
                ->constrained('categories')->onDelete('set null');
            $table->boolean('is_active')->default(true)->after('description');
            $table->integer('order')->default(0)->after('is_active');
            $table->string('image')->nullable()->after('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'is_active', 'order', 'image']);
        });
    }
}; 