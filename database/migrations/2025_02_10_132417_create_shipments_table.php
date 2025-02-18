<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\DHLServiceType;

return new class extends Migration {
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->string('carrier')->default('DHL');
            $table->string('service_type')->default(DHLServiceType::EXPRESS_WORLDWIDE->value);
            $table->string('tracking_number')->nullable();
            $table->string('label_url')->nullable();
            $table->string('shipment_id')->nullable();
            $table->json('shipment_data')->nullable();
            $table->timestamps();
        });

        Schema::table('quotation_pallets', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('routes', function (Blueprint $table) {
            $table->unsignedInteger('delivery_time')->nullable()->change();
            $table->renameColumn('delivery_time','fcl_delivery_time');
            $table->unsignedInteger('lcl_delivery_time')->after('delivery_time')->nullable()->comment('days');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};

