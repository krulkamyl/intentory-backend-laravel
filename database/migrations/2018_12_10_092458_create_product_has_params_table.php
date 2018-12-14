<?php

use App\Classes\Constant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductHasParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Constant::TABLE_PRODUCTHASPARAMS, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_product')->unsigned();
            $table->integer('id_param')->unsigned();
            $table->string('value');
            $table->string('created_at');
            $table->string('updated_at');
            $table->collation = 'utf8_unicode_ci';
            $table->charset = 'utf8';
            $table->foreign('id_product')->references('id')->on(Constant::TABLE_PRODUCTS)->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_param')->references('id')->on(Constant::TABLE_PARAMETERS)->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Constant::TABLE_PRODUCTHASPARAMS);
    }
}
