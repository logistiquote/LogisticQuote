<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->integer('quotation_id');
            $table->integer('partner_id');
            $table->integer('user_id');
            $table->string('local_charges')->nullable()->comment('USD');
            $table->string('freight_charges')->nullable()->comment('USD');
            $table->string('destination_local_charges')->nullable()->comment('USD');
            $table->string('customs_clearance_charges')->nullable()->comment('USD');
            $table->string('total')->nullable()->comment('USD');
            $table->string('url')->nullable()->comment('Offer link');
            $table->string('status')->default('active')->comment('active,withdrawn,completed');
            $table->timestamp('valid_till', 0)->nullable();
            $table->string('remarks')->nullable();
            
            $table->string('attachment')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}
