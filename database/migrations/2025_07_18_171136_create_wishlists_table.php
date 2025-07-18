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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('selected_weight')->nullable(); // For weight variant selection
            $table->decimal('selected_price', 10, 2)->nullable(); // Price at time of adding
            $table->text('notes')->nullable(); // User notes
            $table->string('phone_number')->nullable(); // Phone number for contact
            $table->string('status')->default('pending'); // pending, contacted, completed
            $table->timestamp('contacted_at')->nullable(); // When admin contacted user
            $table->timestamps();
            
            // Prevent duplicate entries for same user/product/weight combination
            $table->unique(['user_id', 'product_id', 'selected_weight']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
