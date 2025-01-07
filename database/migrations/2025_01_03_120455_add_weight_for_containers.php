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
            $table->decimal('weight', 10, 2)->nullable()->after('quantity');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->boolean('is_paid')->default(0)->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation_containers', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('is_paid');
        });
    }
};