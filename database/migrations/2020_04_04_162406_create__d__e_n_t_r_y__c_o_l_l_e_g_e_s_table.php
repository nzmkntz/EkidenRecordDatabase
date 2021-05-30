<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDENTRYCOLLEGESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('D_ENTRY_COLLEGES', function (Blueprint $table) {
            $table->char('COLLEGE_CODE', 4);
            $table->integer('YEAR_CODE');
            $table->time('TIME_RECORD')->nullable();
            $table->boolean('OPEN_ENTRY_FLAG');
            $table->boolean('DEFAULT_FLAG')->nullable();
            $table->boolean('SEED_ENTRY_FLAG')->nullable();
            $table->string('MEMO',128)->nullable();
            $table->timestamps();            
            $table->string('INSERT_ID',32)->nullable()->default('test');
            $table->string('UPDATE_ID',32)->nullable()->default('test');    
            
            // 主キー設定
            $table->primary(['COLLEGE_CODE', 'YEAR_CODE']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('D_ENTRY_COLLEGES');
    }
}
