<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->id();
            $table->integer('numcode');
            $table->string('charcode');
            $table->string('name');
            $table->integer('scale');
        });

        Schema::create('currency_rate', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('numcode');
            $table->float('rate', 6, 4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency');
    }
}
