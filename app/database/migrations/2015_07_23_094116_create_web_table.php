<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebTable extends Migration {
    protected $tableName = "web";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName, function($table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string("site", 100);
            $table->string("abbr", 100);
            $table->string('filling_number', 100); //备案号
            $table->string("title", 200);//seo标题
            $table->string("keyword", 200); //SEO关键字
            $table->string("describe", 200);
            $table->string("head_logo", 200);
            $table->string("bottom_logo", 200);
            $table->text("code");
            $table->string('weibo', 200);
            $table->string('qq', 200);
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
