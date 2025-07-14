<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Subcategorías
        if (Schema::hasTable('subcategories')) {
            Schema::table('subcategories', function (Blueprint $table) {
                $table->string('slug')->nullable()->change();
            });
        }
        // Productos
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('slug')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Si quieres revertir, vuelve a dejarlo NOT NULL (ajusta si usabas default)
        if (Schema::hasTable('subcategories')) {
            Schema::table('subcategories', function (Blueprint $table) {
                $table->string('slug')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('slug')->nullable(false)->change();
            });
        }
    }
};
