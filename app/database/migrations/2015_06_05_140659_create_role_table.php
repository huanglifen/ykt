<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration {

    protected $tableName = 'role';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table){
            $table->increments('id');
            $table->string('name', 100); //角色名称
            $table->string('description', 500); //角色描述
            $table->tinyInteger('sort')->unsigned(); //排序
            $table->tinyInteger('status')->unsigned(); //是否启用，1：启用，2：停用
            $table->tinyInteger('default')->unsigned(); //是否默认，1：默认，0：非默认
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
