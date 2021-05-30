<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDENTRYPLAYERSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('D_ENTRY_PLAYERS', function (Blueprint $table) {
            $table->CHAR('PLAYER_CODE', 6);
            $table->CHAR('COLLEGE_CODE', 4);
            $table->INTEGER('YEAR_CODE')->length(11);
            $table->CHAR('SECTION_CODE', 2);
            $table->TIME ('TIME_RECORD');            
            $table->TINYINTEGER('DEFAULT_FLAG')->length(1);
            $table->TINYINTEGER('UNOFFICIAL_FLAG')->length(1);
            $table->timestamps();
            $table->string('INSERT_ID', 32)->nullable();
            $table->string('UPDATE_ID', 32)->nullable();
            
            // 主キー設定
            $table->primary(['YEAR_CODE', 'SECTION_CODE', 'COLLEGE_CODE']);    
            // 検索用インデックス設定
            $table->index(['YEAR_CODE', 'SECTION_CODE'], 'IDX_SELSECT');                
            $table->index(['YEAR_CODE', 'COLLEGE_CODE'], 'IDX_SELCOLLEGE');             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('D_ENTRY_PLAYERS');
    }
}
