<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('quotation_containers')->truncate();
        DB::table('quotations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::table('quotations', function (Blueprint $table) {
            $table->float('insurance_price')->default(0)->after('insurance');
            $table->string('quote_number')->after('route_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('insurance_price');
            $table->dropColumn('quote_number');
        });
    }
};
