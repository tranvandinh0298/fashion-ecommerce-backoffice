<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable("product_reviews")) {
            Schema::create('product_reviews', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('product_id')->nullable();
                $table->tinyInteger('rate')->default(0);
                $table->text('review')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('SET NULL');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_reviews');
    }
}