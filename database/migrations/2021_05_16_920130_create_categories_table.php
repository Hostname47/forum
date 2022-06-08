<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('slug');
            $table->string('description');
            $table->unsignedBigInteger('forum_id');
            $table->text('icon')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('forum_id')->references('id')->on('forums');
            $table->foreign('status_id')->references('id')->on('category_status');
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
        Schema::dropIfExists('categories');
    }
}
