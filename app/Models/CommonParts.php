<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;    // 追加した参照
use App\prefecture;                     // 都道府県マスタモデル
use App\section;                        // 区間マスタモデル
use App\M_COLLEGE;                        // 大学マスタモデル
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
        for ($i = $thisYear; $i >= CommonConst::C_STARTYEAR; $i--){
            $cmbYear = $cmbYear.'    <option name=\'opt'.$i.'\' value=\''.$i.'\'>'.$i.'</option>'."\n";
        }
        $cmbYear = $cmbYear.'  </select>'."\n";

        return $cmbYear;
    }

    /**
     * 都道府県コンボボックス作成
     */ 
    static public function createPrefCmbBox(){
        $Colleges = prefecture::orderBy("PREFECTURE_CODE", "asc")->get();          
        // 都道府県コンボボックス作成
        $cmbColleges = '  <select name=\'cmbColleges\' id=\'cmbColleges\' onchange=\'cfCngYear(this)\'>'."\n";
        foreach ($Colleges as $rowPRF){
            $cmbColleges = $cmbColleges.'    <option name=\'optPref'.$rowPRF->PREFECTURE_CODE.'\' value=\''.$rowPRF->PREFECTURE_CODE.'\'>'.$rowPRF->PREFNAME.'</option>'."\n";
        }
        $cmbColleges = $cmbColleges.'  </select>'."\n";

        return $cmbColleges;
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

    /**
     * 大学コンボボックス作成
     * $pIsIncludeOpenEntryCollege : オープン参加を含むか否か
     */ 
    static public function createCollegesCmbBox($pIsIncludeOpenEntryCollege = false){
        $Colleges;
        if($pIsIncludeOpenEntryCollege){
            $Colleges = M_COLLEGE::orderBy("COLLEGE_CODE", "asc")
            ->where("OPEN_ENTRY_FLAG", "<>", 1)
            ->get();  
        }else{
            $Colleges = M_COLLEGE::orderBy("COLLEGE_CODE", "asc")->get();  
        }
        
        // 大学コンボボックス作成
        $cmbColleges = '  <select name=\'cmbColleges\' id=\'cmbColleges\' >'."\n";
        foreach ($Colleges as $rowColleges){
            $cmbColleges = $cmbColleges.'    <option name=\'optPref'.$rowColleges->COLLEGE_CODE.'\' value=\''.$rowColleges->COLLEGE_CODE.'\'>'.$rowColleges->COLLEGE_NAME.'</option>'."\n";
        }
        $cmbColleges = $cmbColleges.'  </select>'."\n";

        return $cmbColleges;
    }
}