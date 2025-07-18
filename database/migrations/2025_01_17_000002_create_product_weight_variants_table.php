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
        Schema::create('product_weight_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('default_weight_option_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('custom_weight', 8, 2)->nullable(); // for custom weights not in default options
            $table->string('custom_label')->nullable(); // for custom weight labels
            $table->decimal('price', 10, 2); // price for this specific weight
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            // Ensure either default_weight_option_id or custom_weight is set
            $table->index(['product_id', 'is_available']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_weight_variants');
    }
};
