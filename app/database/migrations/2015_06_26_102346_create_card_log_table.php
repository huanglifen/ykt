<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardLogTable extends Migration {
    public $tableName = "card_log";

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
            $table->tinyInteger("type");
            $table->tinyInteger("card_type");
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
