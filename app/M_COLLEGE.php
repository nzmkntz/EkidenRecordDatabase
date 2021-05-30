<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 大学マスタモデル
 */
class M_COLLEGE extends Model
{
    // 参照させたいSQLのテーブル名を指定する
    protected $table = 'M_COLLEGES';

    /***
     * 結合：参加大学記録テーブル
     */
    public function D_ENTRY_COLLEGES()
    {
        return $this->hasMany('App\D_ENTRY_COLLEGES', 'COLLEGE_CODE', 'COLLEGE_CODE');
    }

    /***
     * 結合：出場選手記録テーブル
     */
    public function D_ENTRY_PLAYERS()
    {
        return $this->hasMany('App\D_ENTRY_PLAYERS', 'COLLEGE_CODE', 'COLLEGE_CODE');
    }    
}

