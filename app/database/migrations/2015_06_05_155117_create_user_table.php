<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

    protected $tableName = "user";
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string("name", 100); //用户名
            $table->string("password", 50); //密码
            $table->string("realname", 100); //密码
            $table->integer("role_id");//角色ID
            $table->integer("department_id");//角色ID
            $table->string("tel", 20);//手机号
            $table->string("mail", 100);//电子邮箱
            $table->tinyInteger("status"); //是否启用，1：启用，2：停用
            $table->dateTime("last_login_time");//上次登录时间
            $table->integer("login_count"); //登录次数
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
