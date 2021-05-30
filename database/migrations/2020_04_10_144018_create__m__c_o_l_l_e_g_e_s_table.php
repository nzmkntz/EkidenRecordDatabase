<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMCOLLEGESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('M_COLLEGES', function (Blueprint $table) {
            $table->char('COLLEGE_CODE', 4);
            $table->string('COLLEGE_NAME', 16);
            $table->string('COLLEGE_KANA', 32)->nullable();
            $table->integer('COLOR')->nullable();
            $table->boolean('OPEN_ENTRY_FLAG')->nullable();
            $table->timestamps();
            $table->string('INSERT_ID', 32)->nullable()->default('test');
            $table->string('UPDATE_ID', 32)->nullable()->default('test');

            // 主キー設定
            $table->primary('COLLEGE_CODE');
            // ユニークキー設定
            $table->unique('COLLEGE_NAME');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('M_COLLEGES');
    }
}
