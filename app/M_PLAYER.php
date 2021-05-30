<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_PLAYER extends Model
{
    // 参照させたいSQLのテーブル名を指定する
    protected $table = 'M_PLAYERS';

    /***    
     * 結合：大学マスタ
     */
    public function M_COLLEGES()
    {
        return $this->belongsTo('App\M_COLLEGE', 'COLLEGE_CODE', 'COLLEGE_CODE');
    }  

    /***    
     * 結合：都道府県マスタ
     */
    public function prefectures()
    {
        return $this->belongsTo('App\prefecture', 'PREFECTURE_CODE', 'PREFECTURE_CODE');
    }        
}
