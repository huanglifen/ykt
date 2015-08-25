<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 内容表 内容可以是帮助、新闻、微信素材
 * Class CreateContentTable
 */
class CreateContentTable extends Migration {
    protected $tableName = 'content';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->integer("parent_id"); //微信多条图文时，其他图文的parent_id需要填默认图文的id
            $table->string('title', 150);
            $table->string("url", 200); //微信链接
            $table->string('brief', 1000); //内容简介
            $table->text('content');
            $table->string("cover", 150); //微信封面
            $table->tinyInteger("display"); //是否显示 1 显示 2不显示
            $table->string('source', 100);
            $table->tinyInteger('sort');
            $table->string('author', 100); //编辑人
            $table->tinyInteger('type'); //category为1时，对应content_type表里面的类型，category为2时，1为首页，2为旅游 3为ETC
            $table->integer('start_time');
            $table->integer('end_time');
            $table->tinyInteger('category'); //大类型， 1为帮助 2为新闻
            $table->string("site", 50); //显示位置
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
        Schema::dropIfExists($this->tableName);
	}

}
