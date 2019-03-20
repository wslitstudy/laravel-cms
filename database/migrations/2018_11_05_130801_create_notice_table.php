<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',200);
            $table->mediumText('content');
            $table->smallInteger('sort')->default(0);
            $table->tinyInteger('is_show',1)->default(0);
            $table->integer('update_time');
            $table->integer('create_time');

            $table->index('cate_id');
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
        Schema::dropIfExists('notice');
    }
}
