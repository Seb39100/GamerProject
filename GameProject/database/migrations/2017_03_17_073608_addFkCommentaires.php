<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkCommentaires extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('commentaires', function (Blueprint $table) {
//            $table->integer('sujet_id')->unsigned(); 
//            $table->foreign('sujet_id')->references('id')->on('sujets');
//            $table->integer('actualite_id')->unsigned(); 
//            $table->foreign('actualite_id')->references('id')->on('actualites');
//            $table->integer('user_id')->unsigned(); 
//            $table->foreign('user_id')->references('id')->on('users');
//       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
