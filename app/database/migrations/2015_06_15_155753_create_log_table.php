<?php

use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration {
    protected $tableName = 'log';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->integer("user_id");
            $table->tinyInteger("type");
            $table->string("ip", 30);
            $table->string("content", 200);
            $table->dateTime("time");
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
