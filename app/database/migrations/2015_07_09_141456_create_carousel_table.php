<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselTable extends Migration {

    protected $tableName = 'carousel';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string("url", 100);
            $table->string("picture", 100);
            $table->tinyInteger('sort');
            $table->tinyInteger("type"); //轮播图类型，1首页，2旅游 3 ETC
            $table->tinyInteger("display"); //是否显示，1 显示 2 不显示
            $table->string("remark", 500); //备注
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
