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
        Schema::table('customers', function(Blueprint $table) {
            $table->unsignedSmallInteger('industry_id')->nullable();

            $table->foreign('industry_id','fk_customer_industry_id')
                ->on('industries')
                ->references('id')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function(Blueprint $table) {
            $table->dropForeign('fk_customer_industry_id');
            $table->dropColumn('industry_id');
        });
    }
};
