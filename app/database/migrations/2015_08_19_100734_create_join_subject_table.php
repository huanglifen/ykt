<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJoinSubjectTable extends Migration {
    protected $tableName = 'join_subject'; //报名参加活动用户信息
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->Integer("subject_id");
            $table->string("info", 500);
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
