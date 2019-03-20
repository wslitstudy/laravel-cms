<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_name',30)->comment('分组名称');
            $table->string('auth_ids',200)->comment('权限ids');
            $table->tinyInteger('is_default')->default(0)->comment('默认设置');
            $table->integer('create_time')->default(0)->comment('添加时间');
            $table->integer('update_time')->default(0)->comment('更新时间');

            $table->unique('group_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manage_group');
    }
}
