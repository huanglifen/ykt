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
            $table->string("order_no", 30);
            $table->string("cardno", 50); //加密后的卡号
            $table->string("customer_name", 50); //客户名称
            $table->string("tel", 20);
            $table->double("card_fee", 5, 2); //卡费
            $table->double("deposit", 5 , 2); //押金
            $table->double("recharge_mount", 8, 2);//充值金额
            $table->double("discount", 5, 2); //优惠金额
            $table->double("pay_mount", 8, 2); //实际支付金额
            $table->string("address", 100); //邮寄地址
            $table->tinyInteger("status"); //交易状态
            $table->tinyInteger("post_status"); //邮寄状态
            $table->tinyInteger("deliver"); //快递类型
            $table->string("post_order", 30); //快递单号
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
