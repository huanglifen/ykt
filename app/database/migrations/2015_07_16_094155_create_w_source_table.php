<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWSourceTable extends Migration {
    protected $tableName ="w_source";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->tinyInteger("category");
            $table->integer("parent_id");
            $table->string("title", 150);
            $table->string("desc", 500);
            $table->string("url", 200);
            $table->text('content');
            $table->string("picture", 150);
            $table->tinyInteger("is_del");
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
