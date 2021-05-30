<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSECTIONSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('M_SECTIONS', function (Blueprint $table) {
            $table->id();
            $table->char('SECTION_CODE', 2);
            $table->string('SECTION_NAME', 16)->nullable();
            $table->char('EFFECTIVE_YEAR', 4);
            $table->string('START_RS', 16)->nullable();
            $table->string('END_RS', 16)->nullable();
            $table->float('SECTION_DISTANCE', 4, 1)->nullable();
            $table->timestamps();
            $table->string('INSERT_ID', 32)->nullable()->default('test');
            $table->string('UPDATE_ID', 32)->nullable()->default('test');

            // 主キー設定
            $table->unique(['SECTION_CODE', 'EFFECTIVE_YEAR'], 'UK_SECTYEAR');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('M_SECTIONS');
    }
}
