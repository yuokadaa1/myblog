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
          $table->increments('id');
          $table->smallInteger('meigaraCode');
          $table->string('meigaraName')->default('');
          $table->string('joujouKbnName')->default('');
          $table->string('meigaraNameYomi')->nullable();
          $table->date('date')->nullable();
          $table->boolean('delFlg')->nullable();
          $table->timestamps();

          $table->unique('meigaraCode');
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
