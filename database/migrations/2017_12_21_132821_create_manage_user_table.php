<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->comment('用户名');
            $table->string('password', 32)->comment('密码');
            $table->string('password_salt', 22)->comment('密码盐');
            $table->tinyInteger('is_default')->default(0)->comment('是否是默认用户');
            $table->integer('forbidden_time')->default(0)->comment('禁用时间');
            $table->integer('create_time')->default(0);
            $table->integer('update_time')->default(0);

            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manage_user');
    }
}
