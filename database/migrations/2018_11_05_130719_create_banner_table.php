<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img',200);
            $table->string('url',200)->default('');
            $table->tinyInteger('sort',3)->default(0);
            $table->tinyInteger('is_show',1)->default(0);
            $table->integer('update_time');
            $table->integer('create_time');

            $table->index('sort');
            $table->index('is_show');
            $table->index('create_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner');
    }
}
