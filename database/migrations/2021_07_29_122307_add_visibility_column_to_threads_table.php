<?php

use App\Traits\WithDatabaseDriver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibilityColumnToThreadsTable extends Migration
{
    use WithDatabaseDriver;

    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            if($this->databaseDriverIs("sqlite"))
                $table->unsignedBigInteger('visibility_id')->default('');
            else
                $table->unsignedBigInteger('visibility_id');
            $table->foreign('visibility_id')->references('id')->on('thread_visibility');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropForeign('threads_visibility_id_foreign');
            $table->dropColumn('visibility_id');
        });
    }
}
