<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path', 100);
            $table->tinyInteger('level');
            $table->integer('sort');
            $table->integer('parent_id')->default(0);
            $table->string('icon', 50);
            $table->string('level_path', 100)->default('');

            $table->unique('path');
            $table->index('level');
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manage_menu');
    }
}
