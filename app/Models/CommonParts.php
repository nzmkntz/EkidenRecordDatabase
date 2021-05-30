<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;    // 追加した参照
use App\prefecture;                     // 都道府県マスタモデル
use App\section;                        // 区間マスタモデル
use App\Models\CommonConst;             // 共通定数クラス


////////////////////////
//
// 箱根DB：検索クラス
//
////////////////////////
class CommonParts 
{

    /**
     * 年コンボボックス作成
     */ 
    static public function createYearCmbBox(){
        // 年度コンボボックス作成
        $cmbYear = '  <select name=\'cmbYear\' id=\'cmbYear\' onBlur=\'fcCngDay(this)\'>'."\n";
        $thisYear = date('Y');
        for ($i = CommonConst::C_STARTYEAR; $i <= $thisYear; $i++){
            $cmbYear = $cmbYear.'    <option name=\'opt'.$i.'\' value=\''.$i.'\'>'.$i.'</option>'."\n";
        }
        $cmbYear = $cmbYear.'  </select>'."\n";

        return $cmbYear;
    }

    /**
     * 都道府県コンボボックス作成
     */ 
    static public function createPrefCmbBox(){
        $PRF = prefecture::orderBy("PREFECTURE_CODE", "asc")->get();          
        // 都道府県コンボボックス作成
        $cmbPref = '  <select name=\'cmbPref\' id=\'cmbPref\' onchange=\'cfCngYear(this)\'>'."\n";
        foreach ($PRF as $rowPRF){
            $cmbPref = $cmbPref.'    <option name=\'optPref'.$rowPRF->PREFECTURE_CODE.'\' value=\''.$rowPRF->PREFECTURE_CODE.'\'>'.$rowPRF->PREFNAME.'</option>'."\n";
        }
        $cmbPref = $cmbPref.'  </select>'."\n";

        return $cmbPref;
    }    

    /**
     * 区間コンボボックス作成
     */ 
    static public function createSectCmbBox(){
        // 区間情報取得
        $SCT = section::select('SECTION_CODE', 'SECTION_NAME')->distinct()->orderBy("SECTION_CODE", "asc")->get();          
        // 区間コンボボックス作成
        $cmbSect = '  <select name=\'cmbSect\' id=\'cmbSect\'>'."\n";
        foreach ($SCT as $rowSCT){
            $cmbSect = $cmbSect.'    <option name=\'optSect'.$rowSCT->SECTION_CODE.'\' value=\''.$rowSCT->SECTION_CODE.'\'>'.$rowSCT->SECTION_NAME.'</option>'."\n";
        }
        $cmbSect = $cmbSect.'  </select>'."\n";

        return $cmbSect;
    }  
}