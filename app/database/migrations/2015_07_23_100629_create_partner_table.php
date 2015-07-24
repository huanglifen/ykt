<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerTable extends Migration {
    protected $tableName = "partner";
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string('name', 100);
            $table->string('picture', 100);
            $table->tinyInteger('sort');
            $table->tinyInteger('display'); //1显示，2不显示
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
