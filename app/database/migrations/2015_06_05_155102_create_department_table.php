<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentTable extends Migration {
    protected $tableName = "department";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string('number', 50); //部门编号
            $table->string("name", 100); //部门名称
            $table->integer("superior_id");//上级部门id
            $table->string("description", 500);//部门描述
            $table->tinyInteger("sort");//排序，值越小，越靠前
            $table->tinyInteger("status"); //是否启用，1：启用，2：停用
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
