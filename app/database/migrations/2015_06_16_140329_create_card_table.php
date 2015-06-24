<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardTable extends Migration {
    protected $tableName = 'card';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->integer("card_type")->unsigned(); //卡类型
            $table->string("cardno", 100); //卡号
            $table->string("checkcode", 100); //校验码
            $table->tinyInteger("type")->default(0); //0 虚拟卡， 1实体卡
            $table->tinyInteger("from_type"); //来自哪个微信平台
            $table->tinyInteger("status"); //是否可用，1可用，2不可用
            $table->dateTime('sale_time');//卖出时间
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
