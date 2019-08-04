<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title')->comment('文章标题');
            $table->text('description')->nullable()->comment('文章简介');
            $table->string('photo')->nullable()->comment('文章封面');
            $table->string('publish_time')->comment('文章发布时间');
            $table->mediumText('content')->comment('文章内容');
            $table->tinyInteger('is_wechat')->default(1)->comment('检测是否是微信浏览器  1检测 0不检测');
            $table->tinyInteger('is_vue')->default(0)->comment('是否使用vue');
            $table->tinyInteger('is_ajax')->default(0)->comment('是否使用ajax');
            $table->tinyInteger('check_cookie')->default(0)->comment('检查页面cookie  1检测 0不检测');
            $table->tinyInteger('is_encryption')->default(0)->comment('是否加密');
            $table->tinyInteger('is_jump')->default(1)->comment('是否进行跳转');
            $table->tinyInteger('iframe')->default(1)->comment('使用iframe');
            $table->tinyInteger('source_check')->default(0)->comment('来源检测');
            $table->string('arrow')->nullable()->comment('点击文章内部箭头返回地址');
            $table->string('physics')->nullable()->comment('物理按键点击返回');
            $table->string('music')->nullable()->comment('背景音乐地址');
            $table->string('right_now')->nullable()->comment('网站立即跳转到指定地址');
            $table->text('cnzz')->nullable()->comment('文章流量统计JS代码');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
