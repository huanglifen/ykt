<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration {
    public $tableName = "customer";
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string("name", 200);
            $table->string("openid", 100);
            $table->string("tel", 20);
            $table->Integer("cardid");
            $table->string("idcard", 20);
            $table->string("address", 300);
            $table->string("picture", 300);
            $table->string("remark", 300);
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
