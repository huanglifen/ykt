<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaySettingTable extends Migration {
    protected $tableName = "pay_setting";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string("name", 100);
            $table->tinyInteger("category");
            $table->tinyInteger("type");
            $table->string("support_card"); //支持的卡类型，json格式
            $table->string("support_money"); //支持的金额，json格式
            $table->tinyInteger("status"); //1 启用，2禁用
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
