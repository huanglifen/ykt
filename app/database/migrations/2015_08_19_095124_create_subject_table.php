<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectTable extends Migration {

    protected $tableName = "subject";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string('title', 100);
            $table->text("content");
            $table->string("picture", 100);
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->tinyInteger("status");
            $table->string('remark', 500);
            $table->string('field', 200);
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
