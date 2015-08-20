<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferentialTable extends Migration {
    protected $tableName = "preferential";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string('creator', 60); //创建者
            $table->date("start_time");
            $table->date("end_time");
            $table->string("name", 100);
            $table->tinyInteger("trade_type"); //交易类型，1：充值，2消费
            $table->tinyInteger("pay_type");//支付类型
            $table->double("pay_mount", 10,2); //支付金额
            $table->tinyInteger("strategy"); //优惠策略，1按百分比，2 满减
            $table->tinyInteger("source"); // 优惠来源
            $table->double("prefer_mount", 10, 2);//优惠金额
            $table->double("total_mount", 10, 2); //总交易金额
            $table->double("lowest_mount", 10, 2);//最低限额
            $table->double("highest_mount", 10, 2); //最高限额
            $table->tinyInteger("target"); //优惠对象
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
