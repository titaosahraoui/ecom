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
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->text('description');
                $table->decimal('price', 10, 2);
                $table->integer('sales')->default(0);
                $table->integer('stock');

                // Image fields
                $table->string('image')->nullable();          // Main product image
                $table->string('thumbnail')->nullable();       // Thumbnail version
                $table->json('images')->nullable();            // Additional images array
                $table->string('image_alt_text')->nullable(); // SEO alt text

                // Status fields
                $table->enum('status', ['available', 'out_of_stock', 'coming_soon'])->default('available');
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->text('rejection_reason')->nullable();

                $table->unsignedBigInteger('user_id');
                $table->timestamps();

                // Foreign key to users
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

                // Indexes for better performance
                $table->index('status');
                $table->index('approval_status');
                $table->index('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
