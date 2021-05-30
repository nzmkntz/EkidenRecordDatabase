<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class prefecture extends Model
{
    /***
     * 結合：選手マスタ
     */
    public function M_PLAYERS()
    {
        return $this->hasMany('App\M_PLAYERS', 'PREFECTURE_CODE', 'PREFECTURE_CODE');
    }
}
