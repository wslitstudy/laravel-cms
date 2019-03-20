<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagePowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_power', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path', 100);
            $table->string('method', 10);
            $table->integer('menu_id')->default(0);
            $table->integer('level')->default(0);

            $table->index(['path','method']);
            $table->index('menu_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manage_power');
    }
}
