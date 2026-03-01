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
        Schema::table('order_products', function (Blueprint $table) {
            // نخلي العمود nullable فقط
            $table->unsignedBigInteger('product_variant_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_variant_id')->nullable(false)->change();
        });
    }
};
