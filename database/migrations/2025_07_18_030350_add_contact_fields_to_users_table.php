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
            $table->string('customer_service_email')->nullable()->after('zip_code');
            $table->string('whatsapp_number')->nullable()->after('customer_service_email');
            $table->string('sales_email')->nullable()->after('whatsapp_number');
            $table->string('support_email')->nullable()->after('sales_email');
            $table->string('business_hours')->nullable()->after('support_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'customer_service_email',
                'whatsapp_number',
                'sales_email',
                'support_email',
                'business_hours'
            ]);
        });
    }
};
