<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayTable extends Migration {
    protected $tableName = "payment";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string("serial_number", 50); //流水号
            $table->tinyInteger("category"); //缴费类型
            $table->integer("business"); //缴费商户
            $table->integer("account"); //缴费账号
            $table->string("order_no", 50); //缴费订单编号
            $table->integer("uid"); //客户id
            $table->integer("pay_type"); //支付方式
            $table->integer("pay_account"); //支付账号
            $table->integer("mount"); //交易金额
            $table->tinyInteger("status"); //交易状态， 1：支付成功，2：交易中，3：交易失败
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
