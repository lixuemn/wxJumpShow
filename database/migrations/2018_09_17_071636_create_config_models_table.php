<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->nullable()->comment('父id');
            $table->string('type')->nullable()->comment('类型');
            $table->string('keyword')->nullable()->comment('关键字');
            $table->text('value')->nullable()->comment('配置项');
            $table->string('desc')->nullable()->comment('名称');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config');
    }
}
