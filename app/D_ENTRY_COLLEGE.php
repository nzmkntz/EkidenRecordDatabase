<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 参加大学記録テーブルモデル
 */
class D_ENTRY_COLLEGE extends Model
{
    //参考：https://techacademy.jp/magazine/18781
    protected $fillable = ['COLLEGE_CODE', 'YEAR_CODE'];

    // 参照させたいSQLのテーブル名を指定する
    protected $table = 'D_ENTRY_COLLEGES';

    /***    
     * 結合：大学マスタ
     */
    public function M_COLLEGES()
    {
        return $this->belongsTo('App\M_COLLEGE', 'COLLEGE_CODE', 'COLLEGE_CODE');
    }    
}
