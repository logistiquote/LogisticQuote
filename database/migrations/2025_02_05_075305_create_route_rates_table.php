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
        Schema::table('routes', function (Blueprint $table) {
           $table->date('price_valid_until')->nullable();
        });

        Schema::create('route_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id');
            $table->decimal('ocean_freight')->nullable();
            $table->decimal('terminal_handling_charges')->nullable();
            $table->decimal('total_price')->nullable();
            $table->decimal('min_ocean_freight')->nullable();
            $table->decimal('destination_charges')->nullable();
            $table->timestamps();

            $table->foreign('route_id')
                ->references('id')
                ->on('routes')
                ->onDelete('cascade');
        });

        Schema::table('quotation_pallets', function (Blueprint $table) {
            $table->decimal('length', 10, 2)->nullable()->change();
            $table->decimal('width', 10, 2)->nullable()->change();
            $table->decimal('height', 10, 2)->nullable()->change();
            $table->decimal('volumetric_weight', 10, 2)->change();
            $table->decimal('gross_weight', 10, 2)->change();
            $table->unsignedInteger('quantity')->default(1)->after('gross_weight');
            $table->decimal('price')->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_rates');
    }
};
