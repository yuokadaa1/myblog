<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKawasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kawases', function (Blueprint $table) {
          $table->increments('id');
          $table->char('base',3);
          $table->char('pair',3);
          $table->date('date');
          $table->time('time');
          $table->double('rate',8,5);
          $table->timestamps();

          $table->unique(['base','pair','date','time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kawases');
    }
}
