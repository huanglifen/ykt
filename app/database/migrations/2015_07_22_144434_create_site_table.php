<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteTable extends Migration {
    protected $tableName = "site";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->tinyInteger('type');
            $table->integer("number");
            $table->string("name", 30);
            $table->string("contactor", 100 );
            $table->string("tel", 30);
            $table->string('address', 100);
            $table->integer('start_time');
            $table->integer('end_time');
            $table->string('picture', 100);
            $table->string('remark', 150);
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
