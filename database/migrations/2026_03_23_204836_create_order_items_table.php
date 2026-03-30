<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("order_items", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->unsignedInteger("product_id");
            $table->unsignedSmallInteger("quantity")->default(1);
            $table->decimal("unit_price", 12, 0)->default(0);
            
            $table->decimal("subtotal", 12, 0)->default(0);

            $table
                ->foreign("order_id")
                ->on("orders")
                ->references("id")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreign("product_id")
                ->on("products")
                ->references("id")
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("order_items");
    }
};
