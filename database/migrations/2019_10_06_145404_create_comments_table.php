<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('comments', function (Blueprint $table) {
             $table->increments('id');
             // $table->integer('post_id');
             $table->unsignedInteger('post_id');
             $table->string('body');
             $table->timestamps();
             // $table
             //   ->foreign('post_id')
             //   ->references('id')
             //   ->on('posts')
             //   ->onDelete('cascade');
         });
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
