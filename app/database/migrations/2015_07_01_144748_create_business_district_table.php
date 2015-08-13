<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessDistrictTable extends Migration {
    public $tableName = 'business_district';

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
            $table->string("address", 200);
            $table->Integer("city_id");
            $table->Integer("district_id");
            $table->string("lat", 50);//纬度
            $table->string("lng", 50);//经度
            $table->string("remark", 500);
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
