<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardBindTable extends Migration {
    public $tableName = "card_bind"; //该表管理平台未用到

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->Integer("cutomer_id");
            $table->Integer("card_id");
            $table->tinyInteger("flag");
            $table->tinyInteger("opt_type");
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
		//
	}

}
