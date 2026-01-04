<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Shiprocket Order & Shipment IDs
            $table->string('shiprocket_order_id', 50)->nullable()->after('transaction_id');
            $table->string('shiprocket_shipment_id', 50)->nullable()->after('shiprocket_order_id');
            
            // AWB & Courier Info
            $table->string('shiprocket_awb_code', 50)->nullable()->after('shiprocket_shipment_id');
            $table->integer('shiprocket_courier_id')->nullable()->after('shiprocket_awb_code');
            $table->string('shiprocket_courier_name', 100)->nullable()->after('shiprocket_courier_id');
            
            // Documents
            $table->text('shiprocket_label_url')->nullable()->after('shiprocket_courier_name');
            $table->text('shiprocket_manifest_url')->nullable()->after('shiprocket_label_url');
            $table->text('shiprocket_invoice_url')->nullable()->after('shiprocket_manifest_url');
            
            // Tracking
            $table->string('shiprocket_status', 50)->nullable()->after('shiprocket_invoice_url');
            $table->text('shiprocket_tracking_url')->nullable()->after('shiprocket_status');
            $table->date('shiprocket_pickup_scheduled_date')->nullable()->after('shiprocket_tracking_url');
            $table->date('shiprocket_expected_delivery_date')->nullable()->after('shiprocket_pickup_scheduled_date');
            
            // Indexes
            $table->index('shiprocket_order_id');
            $table->index('shiprocket_awb_code');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['shiprocket_order_id']);
            $table->dropIndex(['shiprocket_awb_code']);
            
            $table->dropColumn([
                'shiprocket_order_id',
                'shiprocket_shipment_id',
                'shiprocket_awb_code',
                'shiprocket_courier_id',
                'shiprocket_courier_name',
                'shiprocket_label_url',
                'shiprocket_manifest_url',
                'shiprocket_invoice_url',
                'shiprocket_status',
                'shiprocket_tracking_url',
                'shiprocket_pickup_scheduled_date',
                'shiprocket_expected_delivery_date',
            ]);
        });
    }
};
