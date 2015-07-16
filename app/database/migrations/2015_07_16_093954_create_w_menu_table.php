<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWMenuTable extends Migration {
    protected $tableName = "w_menu";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->integer("parent_id");
            $table->string("name", 100);
            $table->integer("category");
            $table->tinyInteger("type");
            $table->string("key", 100);
            $table->string("url", 200);
            $table->tinyInteger("is_show");
            $table->tinyInteger("is_del");
            $table->smallInteger("order_no");
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
