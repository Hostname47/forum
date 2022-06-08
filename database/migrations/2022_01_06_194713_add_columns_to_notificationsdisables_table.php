<?php

use App\Traits\WithDatabaseDriver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNotificationsdisablesTable extends Migration
{
    use WithDatabaseDriver;
    
    public function up()
    {
        Schema::table('notificationsdisables', function (Blueprint $table) {
            if($this->databaseDriverIs("sqlite")) {
                $table->string('source_id')->default('');
                $table->string('source_type')->default('');
            } else {
                $table->string('source_id');
                $table->string('source_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notificationsdisables', function (Blueprint $table) {
            $table->dropColumn('source_id');
            $table->dropColumn('source_type');
        });
    }
}
