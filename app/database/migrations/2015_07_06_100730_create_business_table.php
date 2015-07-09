<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTable extends Migration {
    public $tableName = 'business';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string('number', 50); //商户编码
            $table->string("account", 100);//商户账号
            $table->string("name", 100);//商户名称
            $table->string("password", 100);//登录密码
            $table->string('tel', 20)->nullable(); //手机号码
            $table->integer('city_id')->nullable();//所属城市ID
            $table->integer('district_id')->nullable();//所属区域ID
            $table->integer('industry_id')->nullable();//所属行业ID
            $table->integer('business_district_id')->nullable();//商圈ID，默认为无
            $table->string('card_type', 50)->nullable(); //支持的卡类型ID，以|间隔
            $table->string('bank_type', 50)->nullable();//开户行
            $table->string('bank_account', 50)->nullable();//开户账号
            $table->string('tariff', 50)->nullable(); //税号
            $table->string('license', 50)->nullable();//执照号码
            $table->string('contacter', 50)->nullable();//联系人
            $table->string('phone', 20)->nullable();//电话号码
            $table->string('email', 50)->nullable();//电子邮箱
            $table->string('qq', 12)->nullable();//qq
            $table->string('unique_number', 50)->nullable();//一卡通分配的唯一编码
            $table->decimal('discount', 5, 2)->nullable();//协议折扣
            $table->string('lat', 10);//纬度
            $table->string('lng', 10);//经度
            $table->tinyInteger('star');//星级
            $table->string('picture', 50);//图片
            $table->string('promotion_pic', 50); //促销图片
            $table->string('description', 500); //商户简介
            $table->string('app_description', 500); //手机商户简介
            $table->tinyInteger('status'); //商户状态，1 可用，2：禁用
            $table->string('integral_number', 50);//积分系统商户编码
            $table->tinyInteger('level'); //商户级别
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
