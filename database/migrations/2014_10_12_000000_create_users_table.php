<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->string('mobile', 11)->unique();
            $table->string('email', 128)->unique();
            $table->string('password', 128);
            $table->string('parent_id', 11);
            $table->string('is_admin', 1);
            $table->string('is_agent', 1);
            $table->string('sex', 1);
            $table->string('province', 128);
            $table->string('city', 128);
            $table->string('country', 128);
            $table->string('headimgurl', 255);
            $table->string('unionid', 255);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
