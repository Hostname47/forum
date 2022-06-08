<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadclosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threadcloses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thread_id');
            $table->unsignedBigInteger('closed_by');
            $table->unsignedBigInteger('reason_id');

            $table->foreign('thread_id')->references('id')->on('threads')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('closed_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reason_id')->references('id')->on('closereasons');
            
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
        Schema::dropIfExists('threadcloses');
    }
}
