<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeigaraListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meigara_lists', function (Blueprint $table) {
          // $table->increments('id');
          $table->smallInteger('meigaraCode')->primary();
          $table->string('meigaraName')->nullable();
          $table->string('joujouKbnName')->nullable();
          $table->string('meigaraNameYomi')->nullable();
          $table->date('date')->nullable();
          $table->boolean('delFlg')->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meigara_lists');
    }
}
