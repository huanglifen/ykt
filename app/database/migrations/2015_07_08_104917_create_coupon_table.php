<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 优惠券
 * Class CreateCouponTable
 */
class CreateCouponTable extends Migration {
    public $tableName = 'coupon';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string('title', 100);
            $table->string('picture', 100);//优惠券图片
            $table->integer('amount');//数量
            $table->integer('remain_amount');//剩余数量
            $table->integer('city_id');
            $table->integer('start_time');
            $table->integer('end_time');
            $table->text('content');
            $table->tinyInteger('status');//状态 1 可用 2 禁用
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
