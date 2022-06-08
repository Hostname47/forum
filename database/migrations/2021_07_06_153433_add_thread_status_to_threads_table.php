<?php

use App\Traits\WithDatabaseDriver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThreadStatusToThreadsTable extends Migration
{
    use WithDatabaseDriver;
    
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            if($this->databaseDriverIs("sqlite"))
                $table->unsignedBigInteger('status_id')->default('');
            else
                $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('thread_status');
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
            $table->dropForeign('threads_status_id_foreign');
            $table->dropColumn('status_id');
        });
    }
}
