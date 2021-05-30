<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMPLAYERSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('M_PLAYERS', function (Blueprint $table) {
            $table->char('PLAYER_CODE', 6);
            $table->string('PLAYER_NAME', 16)->nullable();
            $table->string('PLAYER_KANA', 32)->nullable();
            $table->char('COLLEGE_CODE', 4);
            $table->integer('ADMISSION_YEAR')->length(4)->nullable();
            $table->string('HIGHSCHOOL', 32)->nullable();
            $table->char('PREFECTURE_CODE', 2)->nullable();
            $table->string('CITY', 16)->nullable();
            $table->timestamps();
            $table->string('INSERT_ID', 32)->nullable()->default('test');
            $table->string('UPDATE_ID', 32)->nullable()->default('test');
        
            // 主キー設定
            $table->primary('PLAYER_CODE');      

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('M_PLAYERS');
    }
}
