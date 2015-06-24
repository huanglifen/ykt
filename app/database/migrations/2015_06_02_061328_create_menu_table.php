<?php

use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration {
    private $tableName = 'menu';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function($table){
            $table->increments('id');
            $table->string('number', 50); //菜单编号
            $table->string('group', 50);   //菜单分组
            $table->tinyInteger('level')->unsigned(); //菜单级别
            $table->string('name', 100); //菜单名称
            $table->integer('parent_id')->unsigned(); //上级菜单
            $table->string('url')->nullable(); //链接地址
            $table->tinyInteger('sort')->unsigned(); //排序
            $table->tinyInteger('display')->unsigned(); //是否显示
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
