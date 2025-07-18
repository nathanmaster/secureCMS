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
        Schema::create('default_weight_options', function (Blueprint $table) {
            $table->id();
            $table->string('value')->unique(); // e.g., '0-100', '100-250', '1000+', or 'set-3.5'
            $table->string('label'); // e.g., 'Light (0-100g)', '1/8', '1/4'
            $table->decimal('min_weight', 8, 2)->nullable(); // minimum weight in grams (for ranges)
            $table->decimal('max_weight', 8, 2)->nullable(); // maximum weight in grams (for ranges)
            $table->boolean('is_set_value')->default(false); // true if this is a specific weight (e.g., 3.5g = "1/8")
            $table->decimal('set_weight', 8, 2)->nullable(); // specific weight in grams (for set values)
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_weight_options');
    }
};
