<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeOptionSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('attribute_option_sku')) {
            Schema::create('attribute_option_sku', function (Blueprint $table) {
                $table->foreignId('sku_id')->constrained("skus");
                $table->foreignId('attribute_option_id')->constrained("attribute_options");
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
        Schema::dropIfExists('attribute_option_sku');
    }
}
