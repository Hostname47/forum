<?php

use App\Traits\WithDatabaseDriver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityColumnToFaqsTable extends Migration
{
    use WithDatabaseDriver;

    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            if($this->databaseDriverIs("sqlite"))
                $table->integer('priority')->default('');
            else
                $table->integer('priority');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
}
