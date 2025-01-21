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
        Schema::table('quotation_containers', function (Blueprint $table) {
            $table->dropForeign(['route_container_id']);

            $table->unsignedBigInteger('route_container_id')->nullable()->change();

            $table->foreign('route_container_id')
                ->references('id')
                ->on('route_containers')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
