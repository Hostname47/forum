<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reach', function (Blueprint $table) {
            $table->id();
            // Reach users
            $table->unsignedBigInteger('reacher')->nullable();
            $table->unsignedBigInteger('reachable');
            /**
             * Resource (Notice that here we don't have to add foreign key to resource_id because the resource may 
             * be deleted)
             */
            $table->unsignedBigInteger('resource_id');
            $table->string('resource_type');

            $table->foreign('reacher')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('reachable')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->ipAddress('reacher_ip');
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
        Schema::dropIfExists('user_reach');
    }
}
