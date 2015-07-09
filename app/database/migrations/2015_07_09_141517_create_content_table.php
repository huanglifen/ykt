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
            $table->string('title', 500);
            $table->string('brief', 1000); //内容简介
            $table->text('content');
            $table->tinyInteger("display"); //是否显示 1 显示 2不显示
            $table->string('source', 100);
            $table->tinyInteger('sort');
            $table->string('author', 100); //编辑人
            $table->tinyInteger('type'); //category为1时，对应content_type表里面的类型，category为2时，1为首页，2为旅游 3为ETC
            $table->tinyInteger('category'); //大类型， 1为帮助 2为新闻
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
