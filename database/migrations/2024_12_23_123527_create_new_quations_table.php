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
        Schema::dropIfExists('quotations');

        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('restrict');
            $table->string('status')->default('active');
            $table->string('type', 50)->nullable();
            $table->string('transportation_type', 50);
            $table->date('ready_to_load_date')->nullable();
            $table->string('incoterms', 50)->nullable();
            $table->string('pickup_address')->nullable();
            $table->string('destination_address')->nullable();
            $table->decimal('value_of_goods', 15, 2)->nullable();
            $table->text('description_of_goods')->nullable();
            $table->boolean('is_stockable')->default(false);
            $table->boolean('is_dgr')->default(false);
            $table->boolean('is_clearance_req')->default(false);
            $table->boolean('insurance')->default(false);
            $table->string('attachment', 191)->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('total_weight', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->default(0.00);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('quotation_containers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->onDelete('cascade');
            $table->foreignId('route_container_id')->constrained('route_containers')->onDelete('restrict');
            $table->integer('quantity');
            $table->decimal('price_per_container', 10, 2);
            $table->decimal('total_price', 10, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::create('quotation_pallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->onDelete('cascade');
            $table->decimal('length', 10, 2);
            $table->decimal('width', 10, 2);
            $table->decimal('height', 10, 2);
            $table->decimal('volumetric_weight', 10, 2)->nullable();
            $table->decimal('gross_weight', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
