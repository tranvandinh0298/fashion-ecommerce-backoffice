<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->string("code")->unique();
                $table->double("amount")->default(0);
                $table->double("payment_fee")->default(0);
                $table->double("total_amount")->default(0);
                $table->foreignId("payment_method_id")->constrained("payment_methods");
                $table->foreignId("user_id")->constrained("users");
                $table->tinyInteger("active")->default(0);
                $table->timestamps();
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
        Schema::dropIfExists('transactions');
    }
}
