<?php

use App\Traits\WithDatabaseDriver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountStatusToUsersTable extends Migration
{
    use WithDatabaseDriver;

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if($this->databaseDriverIs("sqlite"))
                $table->unsignedBigInteger('account_status')->default('');
            else
                $table->unsignedBigInteger('account_status');
            $table->foreign('account_status')->references('id')->on('account_status');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_account_status_foreign');
            $table->dropColumn('account_status');
        });
    }
}
