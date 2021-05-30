<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    /***
     * 結合：出場選手記録テーブル
     */
    public function D_ENTRY_PLAYERS()
    {
        return $this->hasMany('App\D_ENTRY_PLAYERS', 'SECTION_CODE', 'SECTION_CODE');
    }  
}
