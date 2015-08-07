<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeTable extends Migration {
    protected $tableName = "exchange";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string("order_no", 30);//订单号
            $table->string("trade_no", 100); //交易号
            $table->Integer("business_id"); //商户id
            $table->Integer("cardno"); //卡号
            $table->tinyInteger("type"); //交易类型
            $table->double("mount"); //交易金额
            $table->double("pay_mount"); //支付金额
            $table->tinyInteger("pay_type"); //支付方式
            $table->tinyInteger("status"); //交易状态 1 未支付 2 交易成功 3 交易失败
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
