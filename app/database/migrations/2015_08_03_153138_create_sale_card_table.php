<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleCardTable extends Migration {
    protected $tableName = 'sale_card';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string("order_id", 30);
            $table->string("cardno", 100); //加密后的卡号
            $table->string("customer_name"); //客户名称
            $table->string("tel", 20);
            $table->Integer("card_fee"); //卡费
            $table->Integer("deposit"); //押金
            $table->Integer("recharge_mount");//充值金额
            $table->Integer("discount"); //优惠金额
            $table->Integer("pay_mount"); //实际支付金额
            $table->string("address", 100); //邮寄地址
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
