<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrefecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefectures', function (Blueprint $table) {
            // 各種カラム作成
            $table->char('PREFECTURE_CODE', 2);
            $table->string('PREFNAME', 8);
            $table->string('PREFKANA', 16);
            $table->timestamps();

            // 主キー設定
            $table->primary('PREFECTURE_CODE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prefectures');
    }
}
