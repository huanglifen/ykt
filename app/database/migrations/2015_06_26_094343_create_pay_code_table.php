<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayCodeTable extends Migration {
    public $tableName = "pay_code";
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->Integer("uid");
            $table->Integer("cardid");
            $table->string("orderid", 50);
            $table->string("token", 50);
            $table->tinyInteger("from_type");
            $table->timestamp('expire');
            $table->timestamp('created_at');
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
