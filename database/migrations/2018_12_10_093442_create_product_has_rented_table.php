<?php

use App\Classes\Constant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductHasRentedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Constant::TABLE_PRODUCTHASRENTED, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_product')->unsigned();
            $table->integer('id_customer')->unsigned();
            $table->string('rented_time');
            $table->string('duration_time');
            $table->boolean('is_rented')->default(true);
            $table->boolean('is_denuncation')->default(false);
            $table->string('created_at');
            $table->string('updated_at');
            $table->collation = 'utf8_unicode_ci';
            $table->charset = 'utf8';
            $table->foreign('id_product')->references('id')->on(Constant::TABLE_PRODUCTS)->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_customer')->references('id')->on(Constant::TABLE_CUSTOMERS)->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Constant::TABLE_PRODUCTHASRENTED);
    }
}
