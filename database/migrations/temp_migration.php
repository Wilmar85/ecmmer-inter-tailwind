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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Mi Tienda');
            $table->string('customer_service_email')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('whatsapp_float_button')->nullable();
            $table->string('sales_email')->nullable();
            $table->string('support_email')->nullable();
            $table->string('business_hours')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
