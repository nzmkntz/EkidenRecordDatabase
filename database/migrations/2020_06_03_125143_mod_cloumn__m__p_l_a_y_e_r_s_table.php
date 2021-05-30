<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModCloumnMPLAYERSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('M_PLAYERS', function (Blueprint $table) {
            // PLAYER_NAMEの桁数を32かつNULL不可に
            $table->string('PLAYER_NAME', 32)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('M_PLAYERS', function (Blueprint $table) {
            $table->string('PLAYER_NAME', 16)->nullable()->change();        
        });
    }
}
