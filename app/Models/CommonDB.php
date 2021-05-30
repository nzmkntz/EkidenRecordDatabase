<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;    // 追加した参照
use App\M_COLLEGE;                      // 大学マスタモデル
use App\D_ENTRY_COLLEGE;                // 年別記録テーブルモデル
use App\D_ENTRY_PLAYER;                 // 選手別記録テーブルモデル
use App\section;                        // 区間マスタモデル


////////////////////////
//
// 箱根DB：検索クラス
//
////////////////////////
class CommonDB 
{

    /**
     * 大学マスタ検索
     * @param request $request request object
     * @param variant $pKind kind of search type
     * @param int $pPaginate returning paginate number  
     * @return Object Dataset of M_COLLEGES
     */
    static public function searchM_COLLEGES(request $request, $pKind, $pPaginate = null){
        // TODO:条件指定処理が適当なので治すこと
        if($request->has("submit")
        && $pKind == "searchM_COLLEGE"){
            // 大学マスタ登録の条件検索
            if($request->has("txtCollege_Name")){
                // 大学名
                $col = "COLLEGE_NAME";
                $var = $request->get("txtCollege_Name");
            }
            else if($request->has("txtCollege_Kana")){
                // 大学名カナ
                $col = "COLLEGE_KANA";                
                $var = $request->get("txtCollege_Kana");
            }

        }
        // else if($request->has("submit")
        // && $pKind == "searchM_PLAYER"){
        //     // 選手マスタ登録の大学条件検索
        //     $col = "COLLEGE_CODE";
        //     // 条件が指定されているか
        //     if($request->get("cmbCollege") != ""){
        //         $var = $request->get("cmbCollege");
        //     }
        //     else{
        //         $var = "%";
        //     }

        // }        
        else{
            $col = "COLLEGE_NAME";                
            $var = "%";
        }

        if(is_null($pPaginate)){
            // 全件取得
            $MCL = M_COLLEGE::where($col, "like", "%{$var}%")             
            ->orderBy("COLLEGE_CODE", "asc")
            ->get();
        }
        else{
            // 対象ページ分取得
            $MCL = M_COLLEGE::where($col, "like", "%{$var}%")             
            ->orderBy("COLLEGE_CODE", "asc")
            ->paginate($pPaginate);
            // URLの指定（登録処理の後はURLが変わってしまいリンクがおかしくなるため）
            $MCL->setPath("mstColleges");
        }

        return $MCL;
    }

    /**
     * 年別記録テーブル取得（データセット返却版）
     * @return Object Dataset of D_ENTRY_COLLEGES
     */
    static public function searchD_ENTRY_COLLEGES(request $request, &$pRowCnt, $pSelType = null){
        if($request->has("cmbYear")){
            // 記録検索時
            $selYear = $request->get("cmbYear");
        }
        else if($request->has("hdnSelYear")){
            // 記録登録後
            $selYear = $request->get("hdnSelYear");
        }
        else{
            return "結果なし";
        }

        // 検索タイプの取得元を判断
        if(is_null($pSelType)){
            $selType = "";
        }
        else{
            $selType = $pSelType;
        }

        // 検索・登録に使用するコード値を保持
        $selTypeCode = "";
        $column = "";
        $orderColumn = "TIME_RECORD";
        $orderAscDesc = "asc";
        if($request->has("hdnSelTypeCode") == true){
            // 登録の場合
            $selTypeCode = $request->get("hdnSelTypeCode");
        }
        else if($selType == "chkTypeSect"){
            // TODO:共通化するならchkとrdoで分かれているのがよくない
            // 検索・区間指定の場合
            $selTypeCode = $request->get("cmbSect");
            $column = "SECTION_CODE";
        }
        else if($selType == "chkTypeCollege"){
            // TODO:共通化するならselTypeの値がchkとrdoで分かれているのがよくない
            // 検索・大学指定の場合
            $selTypeCode = $request->get("cmbCollege");
            $column = "COLLEGE_CODE";         
            $orderColumn = "SECTION_CODE";
            $orderAscDesc = "asc";               
        }        

        // DB検索
        if($selType == ""){
            // その年の記録を全て取得
            $DEC = D_ENTRY_COLLEGE::where("YEAR_CODE", $selYear) 
            ->orderByRaw('TIME_RECORD IS NULL asc')    // NULLを後にする
            ->orderBy($orderColumn, $orderAscDesc)
            ->get();
        }
        else{
            // その年の大学か区間のを全て取得
            $DEC = D_ENTRY_PLAYER::where("YEAR_CODE", $selYear) 
            ->where($column, $selTypeCode)
            ->orderByRaw('TIME_RECORD IS NULL asc')    // NULLを後にする
            ->orderBy($orderColumn, $orderAscDesc)
            ->get();
        }

        $pRowCnt = $DEC->count();

        return $DEC;

    }    

}