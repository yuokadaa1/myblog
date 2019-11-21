<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeigarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meigaras', function (Blueprint $table) {
          $table->increments('id');
          $table->smallInteger('meigaraCode');
          $table->char('meigaraCodeA',1)->default('');
          $table->date('date');
          $table->time('time')->nullable();
          $table->smallInteger('price')->nullable();
          $table->smallInteger('openingPrice')->nullable();
          $table->smallInteger('closingPrice')->nullable();
          $table->smallInteger('highPrice')->nullable();
          $table->smallInteger('lowPrice')->nullable();
          $table->mediumInteger('volume')->nullable();
          $table->integer('tradingValue')->nullable();
          $table->timestamps();

          // ユニークキー設定
          $table->unique(['meigaraCode', 'meigaraCodeA' ,'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meigaras');
    }
}
