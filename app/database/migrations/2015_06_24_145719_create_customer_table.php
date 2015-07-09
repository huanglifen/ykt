<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration {
    public $tableName = "customer";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function($table) {
            $table->increments("id");
            $table->string("username", 200);
            $table->string("openid", 100);
            $table->string("mobile", 20);
            $table->string("idcard", 20);//身份证号
            $table->string("address", 300);
            $table->double("latitude");
            $table->double("longitude");
            $table->Integer("cardid"); //卡号
            $table->tinyInteger("status");
            $table->string("system", 10);
            $table->string("version", 15);
            $table->tinyInteger("type");
            $table->string("note", 300);
            $table->tinyInteger("from_type");
            $table->string("picture", 200);
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
