<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class D_ENTRY_PLAYER extends Model
{
    // 参照させたいSQLのテーブル名を指定する
    protected $table = 'D_ENTRY_PLAYERS';

    /***    
     * 結合：大学マスタ
     */
    public function M_COLLEGES()
    {
        return $this->belongsTo('App\M_COLLEGE', 'COLLEGE_CODE', 'COLLEGE_CODE');
    }       

    /***    
     * 結合：選手マスタ
     */
    public function M_PLAYERS()
    {
        return $this->belongsTo('App\M_PLAYER', 'PLAYER_CODE', 'PLAYER_CODE');
    }    

    /***    
     * 結合：区間マスタ
     */
    public function sections()
    {
        return $this->belongsTo('App\section', 'SECTION_CODE', 'SECTION_CODE');
    }        

}
