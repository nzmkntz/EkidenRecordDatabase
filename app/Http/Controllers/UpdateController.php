<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;    // View操作のため参照追加
use Illuminate\Support\Facades\DB;      // DB操作するため参照追加
use App\M_COLLEGE;                      // モデル操作するため参照追加
use App\M_PLAYER;                       // モデル操作するため参照追加
use App\D_ENTRY_COLLEGE;                // モデル操作するため参照追加
use App\D_ENTRY_PLAYER;                 // モデル操作するため参照追加
use App\Models\CommonParts;             // 共通パーツクラス
use App\Models\CommonConst;             // 共通定数クラス

/**
 *
 * 箱根DB：登録クラス
 *
 */
class UpdateController extends Controller
{
    /**
     * 認証
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // 登録：メイン
    public function updateMain(){

        return View::make("/update/updateMain");

    }

    // 登録：各種登録
    public function updateKind($kind, Request $request){
        if($kind == "recPlayer"){     
            // 記録登録（選手別）
            $cmbYear = CommonParts::createYearCmbBox();
            $cmbSect = CommonParts::createSectCmbBox();
            // 大学マスタは全大学を表示（ページネーション指定なし）   
            $MCL = $this->searchM_COLLEGES($request, $kind);            
            return View::make("/update/recPlayer", ['cmbYear' => $cmbYear, 'cmbSect' => $cmbSect, 'mstCollegesList' => $MCL]);
        }
        else if($kind == "recYear"){
            // 記録登録（年別）
            $cmbYear = CommonParts::createYearCmbBox();            
            return View::make("/update/recYear", ['cmbYear' => $cmbYear]);
        }
        else if($kind == "mstColleges"){        
            // 大学マスタ登録
            $MCL = $this->searchM_COLLEGES($request, $kind, CommonConst::C_DEFPAGE);
            return View::make("/update/mstColleges", ["mstCollegesList" => $MCL]);
        }
        // 選手マスタのページネーション
        else if($kind == "mstPlayers"){
            // 選手マスタ登録
            $cmbYear = CommonParts::createYearCmbBox();     
            $cmbPref = CommonParts::createPrefCmbBox();  
            // 大学マスタは全大学を表示（ページネーション指定なし）   
            $MCL = $this->searchM_COLLEGES($request, $kind);   
            $MCL = $this->searchM_COLLEGES($request, $kind);          
            // 大学の条件セット
            $collegeCode = null;
            if($request->has("currentConditionOfCollegeCode")){
                $collegeCode = $request->get("currentConditionOfCollegeCode");
            }
            else if($request->has("cmbCollege")){
                $collegeCode = $request->get("cmbCollege");
            };
            // TODO:選手名の条件セット
            // TODO:選手名カナの条件セット              
            $MPY = $this->searchM_PLAYERS($request, CommonConst::C_DEFPAGE, $collegeCode);
            return View::make("/update/mstPlayers", ["mstPlayersList" => $MPY ,"mstCollegesList" => $MCL, 'cmbYear' => $cmbYear, 'cmbPref' => $cmbPref, "currentConditionOfCollegeCode" => $collegeCode ]);
        }
        else if($kind == "searchM_COLLEGES"){  
            // 大学マスタ一覧作成      
            $MCL = $this->searchM_COLLEGES($request, $kind, CommonConst::C_DEFPAGE);
            return View::make("/update/mstColleges", ["mstCollegesList" => $MCL]);
        }
        // 選手マスタの検索
        else if($kind == "searchM_PLAYERS"){  
            // 選手マスタ一覧作成      
            $cmbYear = CommonParts::createYearCmbBox();     
            $cmbPref = CommonParts::createPrefCmbBox();  
            // 大学マスタは全大学を表示（ページネーション指定なし）   
            $MCL = $this->searchM_COLLEGES($request, $kind);   
            // 大学の条件セット
            $collegeCode = null;
            if($request->has("cmbCollege")){
                $collegeCode = $request->get("cmbCollege");
            };            
            // TODO:選手名の条件セット
            // TODO:選手名カナの条件セット            
            $MPY = $this->searchM_PLAYERS($request, CommonConst::C_DEFPAGE, $collegeCode);                     
            return View::make("/update/mstPlayers", ["mstPlayersList" => $MPY ,"mstCollegesList" => $MCL, 'cmbYear' => $cmbYear, 'cmbPref' => $cmbPref, 'currentConditionOfCollegeCode' => $collegeCode]);
        }        
        else if($kind == "updateM_COLLEGES"){
            // 大学マスタ登録
            // 大学コードの設定有無を確認
            $COLLEGE_CODE = "";
            $strUpdMode = "新規登録";
            if($request->has("hidEntryCollege_Code")){
                if($request->get("hidEntryCollege_Code") <> ""){
                    // 大学コードがある場合、変数に設定（=更新処理と判断）
                    $COLLEGE_CODE = $request->get("hidEntryCollege_Code");
                    $strUpdMode = "更新";                    
                }
            }

            // 登録処理
            $strErr = "";
            $updResult = $this->updateM_COLLEGES($request, $COLLEGE_CODE, $strErr);
            // 登録処理は成功したか？
            if($updResult == true){
                // 成功したら登録結果表示
                $strUpdResult = "大学名「".$request->get("txtEntryCollege_Name")."」を".$strUpdMode."完了しました。";
            }
            else{
                // 失敗したらエラー結果表示
                $strUpdResult = "[ERROR]大学名「".$request->get("txtEntryCollege_Name")."」が".$strUpdMode."できませんでした。".$strErr;
            }            
            // 大学マスタ一覧作成
            $MCL = $this->searchM_COLLEGES($request, $kind, CommonConst::C_DEFPAGE);
            return View::make("/update/mstColleges", ["mstCollegesList" => $MCL , "strUpdResult" => $strUpdResult]);
        }
        else if($kind == "updateM_PLAYERS"){
            // 選手マスタ登録
            // 選手コードの設定有無を確認
            $PLAYER_CODE = "";
            $strUpdMode = "新規登録";
            if($request->has("hidEntryPlayer_Code")){
                if($request->get("hidEntryPlayer_Code") <> ""){
                    // 選手コードがある場合、変数に設定（=更新処理と判断）
                    $PLAYER_CODE = $request->get("hidEntryPlayer_Code");
                    $strUpdMode = "更新";                    
                }
            }

            // 登録処理
            $strErr = "";
            $updResult = $this->updateM_PLAYERS($request, $PLAYER_CODE, $strErr);
            // 登録処理は成功したか？
            if($updResult == true){
                // 成功したら登録結果表示
                $strUpdResult = "選手名「".$request->get("txtEntryPlayer_Name")."」を".$strUpdMode."完了しました。";
            }
            else{
                // 失敗したらエラー結果表示
                $strUpdResult = "[ERROR]選手名「".$request->get("txtEntryPlayer_Name")."」が".$strUpdMode."できませんでした。".$strErr;
            }            
            // 選手マスタ一覧作成
            $cmbYear = CommonParts::createYearCmbBox();     
            $cmbPref = CommonParts::createPrefCmbBox();              
            $MPY = $this->searchM_PLAYERS($request, CommonConst::C_DEFPAGE);
            return View::make("/update/mstPlayers", ["mstPlayersList" => $MPY , 'cmbYear' => $cmbYear, 'cmbPref' => $cmbPref, "strUpdResult" => $strUpdResult]);
        }           
    }

    // 登録：年別登録用キー情報検索
    public function updateYearProc($proc, Request $request){
        // 年指定か確認
        if($request->has("submit")){
            $selYear = $request->get("cmbYear");
        }
        else{
            $selYear = $request->get("hdnSelYear");
        };   

        // 登録処理
        $strUpdResult = "";
        if($proc == "update"){ 
            // 登録処理
            $strErr = "";
            $updResult = $this->updateD_ENTRY_COLLEGES($request, $selYear, $strErr);
            // 登録処理は成功したか？
            if($updResult == true){
                // 成功したら登録結果表示
                $strUpdResult = $selYear."年のデータを登録完了しました。";
            }
            else{
                // 失敗したらエラー結果表示
                $strUpdResult = "[ERROR]".$selYear."年のデータが登録できませんでした。".$strErr;
            }
        }     

        // 年別記録一覧作成
        $rowCnt = 0;
        $list = $this->searchD_ENTRY_COLLEGES($request, $rowCnt);

        // url取得
        $url = "/update/recYear";
        $cmbYear = CommonParts::createYearCmbBox();

        // 検索時と登録後で処理を変更
        if($proc == "update"){     
            // 登録後
            return View::make($url, ['cmbYear' => $cmbYear
                                   , 'selYear' => $selYear
                                   , 'results' => $list
                                   , 'updResult' => $strUpdResult
                                   , 'rowCnt' => $rowCnt]);
        }
        else{
            // 検索時
            return View::make($url, ['cmbYear' => $cmbYear
                                   , 'selYear' => $selYear
                                   , 'results' => $list
                                   , 'rowCnt' => $rowCnt]);        
        }
    }

    // 登録：選手別登録用キー情報検索
    public function updatePlayerProc($proc, Request $request){
        // 年の値の取得元を判断
        if($request->has("submit")){
            $selYear = $request->get("cmbYear");
        }
        else{
            $selYear = $request->get("hdnSelYear");
        };

        // 検索タイプの取得元を判断
        if($request->has("rdoTypeSectCollege")){
            // 検索処理の場合はこちら
            $selType = $request->get("rdoTypeSectCollege");
        
        }
        else if($request->has("hdnSelType")){
            // 登録処理の場合はこちら
            $selType = $request->get("hdnSelType");
  
        }

        // 検索・登録に使用するコード値を保持
        $selTypeCode = "";
        if($request->has("hdnSelTypeCode") == true){
            // 登録の場合
            $selTypeCode = $request->get("hdnSelTypeCode");
        }
        else if($selType == "rdoTypeSect"){
            // 検索・区間指定の場合
            $selTypeCode = $request->get("cmbSect");
        }
        else if($selType == "rdoTypeCollege"){
            // 検索・大学指定の場合
            $selTypeCode = $request->get("cmbCollege");
        }

        // 検索・登録に使用するコードの名称を保持
        $selTypeVal = "";
        if($request->has("hdnSelTypeVal") == true){
            // 登録の場合
            $selTypeVal = $request->get("hdnSelTypeVal");
        }        
        else{
            $selTypeVal = $request->get("hdnSelTypeStr");
        }     

        // 登録処理の場合（年情報をhiddenで保持しているかで判断）
        if($request->has("hdnSelYear")){
            // 登録処理
            $strErr = "";
            $updResult = $this->updateD_ENTRY_PLAYERS($request, $selYear, $selType, $selTypeCode, $strErr);
            // 登録処理は成功したか？
            if($updResult == true){
                // 成功したら登録結果表示
                $strUpdResult = $selYear."年の"."データを登録完了しました。";
            }
            else{
                // 失敗したらエラー結果表示
                $strUpdResult = "[ERROR]".$selYear."年のデータが登録できませんでした。".$strErr;
            }           

        }       

        // 選手別記録一覧作成
        $rowCnt = 0;
               
        $list = $this->searchD_ENTRY_PLAYERS($request, $selYear, $selType, $selTypeCode, $rowCnt);
        // デバッグ用
        // return $list;        

        // 選択条件の値を設定
        // foreach($list as $row){
        //     $selTypeVal = $row->SECTION_NAME;
        // }

        // url取得
        $url = "/update/recPlayer";
        // view表示に必要な情報
        $cmbYear = CommonParts::createYearCmbBox();     
        $cmbSect = CommonParts::createSectCmbBox(); 
        $cmbColleges = $this->searchM_COLLEGES($request, "recPlayer", null, false);   // オープン参加チームの場合、大学コンボボックスを設ける         
        // 大学マスタは全大学を表示（ページネーション指定なし）   
        $MCL = $this->searchM_COLLEGES($request, "recPlayer");   

        // 検索時と登録後で処理を変更
        if($proc == "update"){     
            // 登録後
            return View::make($url, ["mstCollegesList" => $MCL
                                   , 'cmbYear' => $cmbYear
                                   , 'cmbSect' => $cmbSect
                                   , 'selYear' => $selYear
                                   , 'selType' => $selType
                                   , 'selTypeVal' => $selTypeVal
                                   , 'selTypeCode' => $selTypeCode
                                   , 'results' => $list
                                   , 'updResult' => $strUpdResult
                                   , 'rowCnt' => $rowCnt
                                   , 'cmbColleges' => $cmbColleges]);
        }
        else{
            // 検索時
            return View::make($url, ["mstCollegesList" => $MCL
                                   , 'cmbYear' => $cmbYear
                                   , 'cmbSect' => $cmbSect
                                   , 'selYear' => $selYear
                                   , 'selType' => $selType
                                   , 'selTypeVal' => $selTypeVal
                                   , 'selTypeCode' => $selTypeCode
                                   , 'results' => $list
                                   , 'rowCnt' => $rowCnt
                                   , 'cmbColleges' => $cmbColleges]);        
        }
    }

    // Ajaxからの処理
    public function updateAjax($proc, Request $request){
        // 処理タイプを判断
        if($proc == "getM_COLLEGES"){
            // 大学マスタ取得処理
            $MCL = $this->searchM_COLLEGES($request, $proc);

            // 結果リストの取得（テキストで作った暫定措置）
            $results = "";
            foreach ($MCL as $rowMCL) {
                $results = $results.$rowMCL->COLLEGE_CODE.":".$rowMCL->COLLEGE_NAME.","; 
            }
            $results = substr($results, 0, strlen($results) - 1);
            //多次元連装配列の使い方がわからない。json形式のデータがつくれない。
            // あとで勉強しなおすこと。今回は文字列で送る。
            // jsonバージョンで試した。これだと1件しか大学データが入らない。foreachやっても後のデータで上書きされてそう
            // jsonのとき
            // $results = array();  
            // $colleges = array();    
            // $tmp = array();
            // $i = 0;
            // foreach ($MCL as $rowMCL) {
            //     $i = $i + 1;
            //     $tmp = array("college_code" => $rowMCL->COLLEGE_CODE, "college_name" => $rowMCL->COLLEGE_NAME.$i);
            //     // $results = $results + array("colleges" => $colleges);
            //     // if($i = 6){break;}
            //     $colleges = array_merge($colleges, $tmp);              
            // }     
            // $results = array("colleges" => $colleges);   
            // return json_encode($results);

            // テキストテスト
            // バグjsonバージョンで試した。これだと1件しか大学データが入らない。foreachやっても後のデータで上書きされてそう
            // $results = ["colleges", ["college_code" => "", "college_name" => ""]];
            // $tmp = array();
            // foreach ($MCL as $rowMCL) {
            //     // $results = $results.$rowMCL->COLLEGE_CODE.$rowMCL->COLLEGE_NAME ; 
            //     array_merge($results["colleges"], ["college_code" => $rowMCL->COLLEGE_CODE, "college_name" => $rowMCL->COLLEGE_NAME]); 
            // }
            // $results += array($MCL[4]->COLLEGE_CODE, $MCL[4]->COLLEGE_NAME); 
            // $results += array($MCL[1]->COLLEGE_CODE, $MCL[1]->COLLEGE_NAME); 
            // return $results;            
        }
        else if($proc == "insertM_COLLEGES"){
            // 大学マスタ登録処理
            $strErr = "";
            $COLLEGE_CODE = "";            
            $updResult = $this->updateM_COLLEGES($request, $COLLEGE_CODE, $strErr);

            $strUpdMode = "登録";
            $arrJson = array();
            // 登録処理は成功したか？
            if($updResult == true){
                // 成功したら登録結果表示
                $arrJson = ["result" => "大学名「".$request->get("txtEntryCollege_Name")."」を".$strUpdMode."完了しました。"];
            }
            else{
                // 失敗したらエラー結果表示
                $arrJson = ["result" => "[ERROR]大学名「".$request->get("txtEntryCollege_Name")."」が".$strUpdMode."できませんでした。".$strErr];
            }     

            // json化
            $results = json_encode($arrJson); 
        }
        // 処理タイプを判断
        else if($proc == "getM_COLLEGESWithoutOpenEntry"){
            // 大学マスタ取得処理
            $MCL = $this->searchM_COLLEGES($request, $proc, null, false);

            // 結果リストの取得（テキストで作った暫定措置）
            $results = "";
            foreach ($MCL as $rowMCL) {
                $results = $results.$rowMCL->COLLEGE_CODE.":".$rowMCL->COLLEGE_NAME.","; 
            }
            $results = substr($results, 0, strlen($results) - 1);        
        }

        return $results;

    }

    /**
     * Ajax_選手名検索
     */
    public function updateAjaxSearchM_PLAYERS(Request $request){
        // 選手マスタ取得処理   
        $MPY = $this->SearchM_PLAYERS($request);
        // 結果リストの取得
        if(is_null($MPY)){
            $results = 0;
        }
        else{
            $results = $MPY->count();
        }
        return $results;
    }

    /**
     * 大学マスタ検索
     */
    public function searchM_COLLEGES(request $request, $pKind, $pPaginate = null, $pIsIncludeOpenEntry = true){
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

        // オープン参加校を含むかどうかの条件を設定
        if($pIsIncludeOpenEntry == true){
            $arrOpenEntry = [0, 1];
        }
        else{
            $arrOpenEntry = [0];
        }

        if(is_null($pPaginate)){
            // 全件取得
            $MCL = M_COLLEGE::where($col, "like", "%{$var}%")
            ->whereIn( "OPEN_ENTRY_FLAG", $arrOpenEntry )
            ->orderBy("COLLEGE_CODE", "asc")
            ->get();
        }
        else{
            // 対象ページ分取得
            $MCL = M_COLLEGE::where($col, "like", "%{$var}%")
            ->whereIn( "OPEN_ENTRY_FLAG", $arrOpenEntry )
            ->orderBy("COLLEGE_CODE", "asc")
            ->paginate($pPaginate);
            // URLの指定（登録処理の後はURLが変わってしまいリンクがおかしくなるため）
            $MCL->setPath("mstColleges");
        }

        return $MCL;
    }

    /**
     * 選手マスタ検索
     */
    public function searchM_PLAYERS(request $request, $pPaginate = null, $pCollegeCode = null, $pPlayerName = null, $pPlayerKana = null){
        // 無条件で全件取得する場合の条件
        $colCOLLEGE_CODE = "COLLEGE_CODE";                
        $varCOLLEGE_CODE = "%"; 
        $colPLAYER_NAME = "PLAYER_NAME";                
        $varPLAYER_NAME = "%"; 
        $colPLAYER_KANA = "PLAYER_KANA";                
        $varPLAYER_KANA = "%";   
        $colPLAYER_CODE ="PLAYER_CODE";

        // ajaxからの処理の場合（選手別記録登録時の選手名検索を想定）
        if($request->has("ajaxFlg")){
            // 全件取得用の条件
            $col = "PLAYER_NAME";                
            $var = $request->get("rowPlayerName");
            $varCOLLEGE_CODE = $request->get("rowCollegeCode"); 
            
            // TODO:一旦ajax空の場合はもうこのifスコープで結果を返す。あとで当関数全体を整理
            $MPY = M_PLAYER::where($col, "=", $var)
            ->where("COLLEGE_CODE", "=", $varCOLLEGE_CODE)
            ->get();

            return $MPY;
        }

        // 引数の条件を設定
        if(isset($pCollegeCode)){
            $varCOLLEGE_CODE = $pCollegeCode;
        }
        if(isset($pPlayerName)){
            $varPLAYER_NAME = $pPlayerName;
        }
        if(isset($pPlayerKana)){
            $varPLAYER_KANA = $pPlayerKana;
        }

        // ページネーションの有無で処理分岐
        // TODO:DBのレコードのPLAYER_KANAがNULLの場合LIKEワイルドカード検索でヒットしない問題の対策必要
        if(is_null($pPaginate)){
            // ページネーションなしで取得
            $MPY = M_PLAYER::where($colCOLLEGE_CODE, "like", "%{$varCOLLEGE_CODE}%")
            ->where($colPLAYER_NAME, "like", "%{$varPLAYER_NAME}%")
            // ->where($colPLAYER_KANA, "like", "%{$varPLAYER_KANA}%")
            ->orderBy($colPLAYER_CODE, "asc")
            ->get();
        }
        else{
            // 対象ページ分のみ取得
            $MPY = M_PLAYER::where($colCOLLEGE_CODE, "like", "%{$varCOLLEGE_CODE}%")
            ->where($colPLAYER_NAME, "like", "%{$varPLAYER_NAME}%")
            // ->where($colPLAYER_KANA, "like", "%{$varPLAYER_KANA}%")
            ->orderBy($colPLAYER_CODE, "asc")
            ->paginate($pPaginate);
            // ->toSql();    // テスト用
            return $MPY;
            // URLの指定（登録処理の後はURLが変わってしまいリンクがおかしくなるため）
            $MPY->setPath("mstPlayers");
        }

        return $MPY;        

    }

    /**
     * 大学マスタ登録・更新
     */
    public function updateM_COLLEGES(request $req, $pCOLLEGE_CODE, &$pStrErr){

        // 大学名重複チェック（DBのUNIQUE制約でやるべきかも）
        $vCOLLEGE_NAME = $req->get("txtEntryCollege_Name");        
        if($this->chkUniqueCollege($vCOLLEGE_NAME, $pCOLLEGE_CODE) == false){
            $pStrErr = "すでに同じ名称の大学が登録されています。";
            return false;
        }

        // 登録か更新か判断
        if($pCOLLEGE_CODE == ""){
            // 新規登録
            $result = false;
            $result = DB::transaction(function() use (&$req, &$vCOLLEGE_NAME) {
                // 大学コードを採番
                $maxCode = str_pad(
                    intVal(
                        DB::table("M_COLLEGES")->max("COLLEGE_CODE")
                    ) + 1
                , 4, "0", STR_PAD_LEFT);
               
                // 新規登録
                $eff = DB::table("M_COLLEGES")
                ->insert(
                    ["COLLEGE_CODE" => $maxCode,
                     "COLLEGE_NAME" => $vCOLLEGE_NAME,
                     "COLLEGE_KANA" => $req->get("txtEntryCollege_Kana"),
                     "OPEN_ENTRY_FLAG" => $this->getChkToFlg($req->get("chkOpen")),
                     "CREATED_AT" => date('Y-m-d H:i:s')
                    ]
                );  
                return $eff;
            });
        }
        else{
            // 更新
            $result = false;
            $result = DB::transaction(function() use (&$req, &$vCOLLEGE_NAME, &$pStrErr) {            
                $effCount = DB::table("M_COLLEGES")
                ->where("COLLEGE_CODE", $req->get("hidEntryCollege_Code"))
                ->update(["COLLEGE_NAME" => $vCOLLEGE_NAME, 
                          "COLLEGE_KANA" => $req->get("txtEntryCollege_Kana"),
                          "OPEN_ENTRY_FLAG" => $this->getChkToFlg($req->get("chkOpen")),                          
                          "UPDATED_AT" => date('Y-m-d H:i:s')                          
                         ]
                );
                // 1件更新できたら成功
                if($effCount == 1){
                    return true;
                }
                else{
                    // デバッグ用
                    $pStrErr = $req->get("hidEntryCollege_Code").$vCOLLEGE_NAME.$effCount;
                    return false;
                }
            });                      
        }

        return $result;
    }

    /**
    * 選手マスタ登録・更新
    */
    public function updateM_PLAYERS(request $req, $pPLAYER_CODE, &$pStrErr){
        // 登録か更新か判断
        if($pPLAYER_CODE == ""){
            // 新規登録
            $result = false;
            $result = DB::transaction(function() use (&$req) {
                // 選手コードを採番
                $maxCode = str_pad(
                    intVal(
                        DB::table("M_PLAYERS")->max("PLAYER_CODE")
                    ) + 1
                , 6, "0", STR_PAD_LEFT);
               
                // 新規登録
                $eff = DB::table("M_PLAYERS")
                ->insert(
                    ["PLAYER_CODE" => $maxCode,
                     "PLAYER_NAME" => $req->get("txtEntryPlayer_Name"),
                     "PLAYER_KANA" => $req->get("txtEntryPlayer_Kana"),
                     "COLLEGE_CODE" => $req->get("cmbEntryCollege"),
                     "ADMISSION_YEAR" => $req->get("cmbYear"),
                     "HIGHSCHOOL" => $req->get("txtEntryHighschool"),                     
                     "PREFECTURE_CODE" => $req->get("cmbPref"),
                     "CITY" => $req->get("txtEntryCity"),
                     "CREATED_AT" => date('Y-m-d H:i:s')
                    ]
                );  
                return $eff;
            });
        }
        else{
            // 更新
            $result = false;
            $result = DB::transaction(function() use (&$req, &$pStrErr) {            
                $effCount = DB::table("M_PLAYERS")
                ->where("PLAYER_CODE", $req->get("hidEntryPlayer_Code"))
                ->update(
                    ["PLAYER_NAME" => $req->get("txtEntryPlayer_Name"),
                     "PLAYER_KANA" => $req->get("txtEntryPlayer_Kana"),
                     "COLLEGE_CODE" => $req->get("cmbEntryCollege"),
                     "ADMISSION_YEAR" => $req->get("cmbYear"),
                     "HIGHSCHOOL" => $req->get("txtEntryHighschool"),
                     "PREFECTURE_CODE" => $req->get("cmbPref"),
                     "CITY" => $req->get("txtEntryCity"),
                     "UPDATED_AT" => date('Y-m-d H:i:s')
                    ]
                );
                // 1件更新できたら成功
                if($effCount == 1){
                    return true;
                }
                else{
                    // デバッグ用
                    // $pStrErr = $req->get("hidEntryPLAYER_Code");
                    return false;
                }
            });
        }   

        return $result;
    }

    /**
     * DB:UNIQUE制約チェック
     */
    public function chkUniqueCollege($pName, $pCode){
        // 対象の値が既に存在するか
        $chk = DB::table("M_COLLEGES")
        ->where([["COLLEGE_NAME", $pName],
                 ["COLLEGE_CODE", "<>", $pCode]
                ])
        ->count();
        if($chk > 0){
            return false;
        } 
        else{
            return true;
        }
    }

    /**
     * HTML:DBのフラグをchekcedに変換
     */
    public function getFlgToChk($pFlg){
        // 対象の値が既に存在するか
        if($pFlg == "1"){
            return "checked";
        } 
        else{
            return "";
        }
    }

    /**
     * DB:フォームの値をDBのフラグに変換
     */
    public function getChkToFlg($pChk){
        // 対象の値が既に存在するか
        if($pChk == "1"){
            return "1";
        } 
        else{
            return "0";
        }
    }

    /**
     * 年別記録テーブル取得（HTML返却版）
     * @return string html
     */
    public function searchD_ENTRY_COLLEGES(request $request, &$pRowCnt){
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

        // DB検索
        $MCL = D_ENTRY_COLLEGE::where("YEAR_CODE", $selYear)             
        ->orderBy("TIME_RECORD", "asc")
        ->get();  

        $pRowCnt = 0;
        if($MCL->count() > 0){
            // 検索結果の取得
            $results = "";
            foreach ($MCL as $rowDEC) {
                // 件数値設定
                $pRowCnt = $pRowCnt + 1;
                // HTML編集
                $results = $results."<tr id=\"row".$pRowCnt."\">"."\n"
               ."    <td class=\"wd45\"><input type=\"checkbox\" id=\"rowDel".$pRowCnt."\" name=\"rowDel".$pRowCnt."\" value=\"1\"></td>"."\n"
               ."    <td class=\"wd180\"><label for=\"rowCollegeCode".$pRowCnt."\" >".$rowDEC->M_COLLEGES->COLLEGE_NAME."</label ></td>"."\n"
               ."    <td><input type=\"text\" id=\"rowTimeRecord".$pRowCnt."\" name=\"rowTimeRecord".$pRowCnt."\" value=\"".$rowDEC->TIME_RECORD."\" onblur=\"fcChkTimeRecord(this)\"></td>"."\n"
               ."    <td><input type=\"checkbox\" id=\"rowOpen".$pRowCnt."\" name=\"rowOpen".$pRowCnt."\" value=\"1\" ".$this->getFlgToChk($rowDEC->OPEN_ENTRY_FLAG)."></td>"."\n"
               ."    <td><input type=\"checkbox\" id=\"rowDefault".$pRowCnt."\" name=\"rowDefault".$pRowCnt."\" value=\"1\" ".$this->getFlgToChk($rowDEC->DEFAULT_FLAG)."></td>"."\n"
               ."    <td><input type=\"checkbox\" id=\"rowSeed".$pRowCnt."\" name=\"rowSeed".$pRowCnt."\" value=\"1\" ".$this->getFlgToChk($rowDEC->SEED_ENTRY_FLAG)."></td>"."\n"
               ."    <td><input type=\"textarea\" id=\"rowMemo".$pRowCnt."\" name=\"rowMemo".$pRowCnt."\" value=\"".$rowDEC->MEMO."\"></td>"."\n"
               ."    <input type=\"hidden\" id=\"rowCollegeCode".$pRowCnt."\" name=\"rowCollegeCode".$pRowCnt."\" value=\"".$rowDEC->COLLEGE_CODE."\">"."\n"
               ."</tr>"."\n";
            }
        }else{
            $results = "結果なし";
        }
        return $results;
    }

    /**
     * 選手別記録テーブル取得
     */
    public function searchD_ENTRY_PLAYERS(request $request, $pYear, $pType, $pCode, &$pRowCnt){
        // 区間で検索か、大学で検索か判断
        if($pType == "rdoTypeSect"){
            // 区間で検索(タイムで整列)
            $MPY = DB::table("D_ENTRY_COLLEGES")
            ->crossjoin("sections")
            ->join("M_COLLEGES", "D_ENTRY_COLLEGES.COLLEGE_CODE", "=", "M_COLLEGES.COLLEGE_CODE") 
            ->leftjoin("D_ENTRY_PLAYERS", function ($lj) use ($pCode) {
                $lj->on("D_ENTRY_COLLEGES.COLLEGE_CODE", "=", "D_ENTRY_PLAYERS.COLLEGE_CODE")
                ->on("D_ENTRY_COLLEGES.YEAR_CODE", "=", "D_ENTRY_PLAYERS.YEAR_CODE")
                ->where("D_ENTRY_PLAYERS.SECTION_CODE", $pCode);
            })
            ->leftjoin("M_PLAYERS", "D_ENTRY_PLAYERS.PLAYER_CODE", "=", "M_PLAYERS.PLAYER_CODE")             
            ->select(
                "sections.SECTION_CODE",                
                "sections.SECTION_NAME",
                "D_ENTRY_COLLEGES.COLLEGE_CODE",
                "D_ENTRY_PLAYERS.OPEN_ENTRY_COLLEGE_CODE",                
                "M_COLLEGES.COLLEGE_NAME",
                "M_COLLEGES.OPEN_ENTRY_FLAG",                
                "D_ENTRY_PLAYERS.PLAYER_CODE",
                "M_PLAYERS.PLAYER_NAME",
                "D_ENTRY_PLAYERS.TIME_RECORD",
                "D_ENTRY_PLAYERS.DEFAULT_FLAG",
                "D_ENTRY_PLAYERS.UNOFFICIAL_FLAG"
            )            
            ->where("D_ENTRY_COLLEGES.YEAR_CODE", $pYear)
            // ->where("D_ENTRY_PLAYERS.YEAR_CODE", $pYear)            
            ->where("sections.SECTION_CODE", $pCode)            
            ->orderByRaw("D_ENTRY_PLAYERS.TIME_RECORD IS NULL ASC")
            ->orderBy("D_ENTRY_PLAYERS.TIME_RECORD", "ASC")
            ->orderBy("D_ENTRY_COLLEGES.COLLEGE_CODE", "ASC")
            ->get(); 
            // デバッグ用  
            // ->toSql();

        }
        else if($pType == "rdoTypeCollege"){
            // 大学で検索(区間で整列)
            // DB検索
            $MPY = DB::table("sections")
            ->crossjoin("M_COLLEGES")
            ->leftjoin("D_ENTRY_PLAYERS", function ($lj) use ($pCode, $pYear) {
                $lj->on("sections.SECTION_CODE", "=", "D_ENTRY_PLAYERS.SECTION_CODE")
                ->where("D_ENTRY_PLAYERS.COLLEGE_CODE", $pCode)
                ->where("D_ENTRY_PLAYERS.YEAR_CODE", $pYear);
            })
            ->leftjoin("M_PLAYERS", "D_ENTRY_PLAYERS.PLAYER_CODE", "=", "M_PLAYERS.PLAYER_CODE")  
            ->select(
                "sections.SECTION_CODE",                
                "sections.SECTION_NAME",
                "M_COLLEGES.COLLEGE_CODE",
                "M_COLLEGES.COLLEGE_NAME",
                "D_ENTRY_PLAYERS.PLAYER_CODE",
                "M_PLAYERS.PLAYER_NAME",
                "D_ENTRY_PLAYERS.TIME_RECORD",
                "D_ENTRY_PLAYERS.DEFAULT_FLAG",
                "D_ENTRY_PLAYERS.UNOFFICIAL_FLAG"
            )                
            ->where("M_COLLEGES.COLLEGE_CODE", $pCode)
            ->orderBy("sections.SECTION_CODE", "asc")
            ->get();
            // デバッグ用  
            // ->toSql();  
            
        }

        return $MPY;

    }    

    /**
     * 年別記録テーブル登録・更新
     */
    public function updateD_ENTRY_COLLEGES(request $req, $pSelYear, &$pStrErr){
        // 新規登録
        $result = false;
        $result = DB::transaction(function() use (&$req, &$pSelYear) {
            // データ削除
            DB::table("D_ENTRY_COLLEGES")->where("YEAR_CODE", $pSelYear)->delete();
                
            // 無限ループ
            $code = "";
            for($i = 1; $i > 0 ; $i++){  
                // 画面の項目が存在しなければループ終了
                $code = $req->get("rowCollegeCode".$i);
                if($code == "") {
                    // 新規追加でないか確認
                    $code = $req->get("rowCmbCollegeCode".$i);                    
                    if($code == ""){
                        break;                   
                    }
                }

                // 削除チェックがあれば登録せず次の処理へ
                if($this->getChkToFlg($req->get("rowDel".$i)) == "1"){
                    continue;
                }

               	// 新規登録
            	DB::table("D_ENTRY_COLLEGES")
            	->insert(
            	    ["YEAR_CODE" => $pSelYear,
            	     "COLLEGE_CODE" => $code,
            	     "TIME_RECORD" => $req->get("rowTimeRecord".$i),
            	     "OPEN_ENTRY_FLAG" => $this->getChkToFlg($req->get("rowOpen".$i)),
            	     "DEFAULT_FLAG" => $this->getChkToFlg($req->get("rowDefault".$i)),
            	     "SEED_ENTRY_FLAG" => $this->getChkToFlg($req->get("rowSeed".$i)),
            	     "MEMO" => $req->get("rowMemo".$i)
            	     ]
                );
                
            } 
            // トランザクション結果
            return true;

        });  
        return $result;
    }

    /**
     * 年別記録テーブル登録・更新
     */
    public function updateD_ENTRY_PLAYERS(request $req, $pSelYear, $pSelType, $pSelTypeVal, &$pStrErr){
        // 新規登録
        $result = false;
        $result = DB::transaction(function() use (&$req, &$pSelYear, &$pSelType, &$pSelTypeVal) {
            // タイプ判定
            if($pSelType == "rdoTypeSect"){
                $colName = "SECTION_CODE";
            }
            else if($pSelType == "rdoTypeCollege"){
                $colName = "COLLEGE_CODE";
            }
            // 年・区間（年・大学）のデータ削除
            DB::table("D_ENTRY_PLAYERS")
            ->where("YEAR_CODE", $pSelYear)
            ->where($colName, $pSelTypeVal)            
            ->delete();
                
            // 新規選手コード変数を定義
            $newCode = "";
            // ループ処理開始（画面上の項目数分ループする）
            for($i = 1; $i > 0 ; $i++){  
                // 画面の項目が存在しなければループ終了
                if($req->has("rowPlayerCode".$i) == false){
                    break;                   
                }                

                // 選手名、タイムが両方入力されていなければ削除（登録しないで次へ）
                if($req->filled("rowPlayerName".$i) == false
                && $req->filled("rowTimeRecord".$i) == false) {
                    continue;
                }
                
                // 選手コードが空（記録の新規登録）の場合
                $playerCode = $req->get("rowPlayerCode".$i);
                $playerName = $req->get("rowPlayerName".$i);
                $collegeCode = $req->get("rowCollegeCode".$i); 
                // オープン参加の場合、参加大学コードを取得
                $openEntryCollegeCode = null;
                if($req->has("cmbOpenEntryCollege".$i) == true){
                    $openEntryCollegeCode  = $req->get("cmbOpenEntryCollege".$i);                
                }                                
                if($playerCode == ""){
                    // 選手コードを選手マスタから取得
                    $playerCode = $this->getPlayerCodeByName($playerName, $collegeCode);
                    // 選手がマスタに存在しない場合
                    if($playerCode == ""){  
                        // 選手が存在しなければ新規登録
                        // コードを採番
                        if($newCode == ""){
                            $newCode = $this->getMaxPlayerCode() + 1;
                        }
                        else{
                            $newCode = $newCode + 1;
                        }

                        // 新規最大コード登録用変数に設定
                        $playerCode = sprintf('%06d', $newCode);

                        // 選手マスタ新規登録処理
                        $this->sinplifyInsertM_PLAYERS($playerCode,$playerName,$collegeCode);

                    }

                }

               	// 新規登録
            	DB::table("D_ENTRY_PLAYERS")
            	->insert(
                    [ "PLAYER_CODE" => $playerCode,
                      "YEAR_CODE" => $pSelYear,
                      "COLLEGE_CODE" => $collegeCode,
                      "OPEN_ENTRY_COLLEGE_CODE" => $openEntryCollegeCode,                                      
                      "SECTION_CODE" => $req->get("rowSectionCode".$i),
            	      "TIME_RECORD" => $req->get("rowTimeRecord".$i),                      
                      "DEFAULT_FLAG" => $this->getChkToFlg($req->get("rowDefault".$i)),
            	      "UNOFFICIAL_FLAG" => $this->getChkToFlg($req->get("rowUnofficial".$i)),                      
                      "CREATED_AT" => date('Y-m-d H:i:s')
                     ]
                     
                );
                
            } 
            // トランザクション結果
            return true;

        });  
        return $result;
    }

    /**
     * 選手マスタ検索
     */
    public function getPlayerCodeByName($pPlayerName, $pCollegeCode){
        // 
        $result = M_PLAYER::select("PLAYER_CODE")
        ->where("PLAYER_NAME", "=", $pPlayerName)
        ->where("COLLEGE_CODE", "=", $pCollegeCode)      
        ->get();

        // 複数件あった場合はエラー
        if($result->count() > 1){
            // 複数件あった場合はエラー
            throw new Exception;
        }
        else if($result->count() == 1){
            // 一致する場合は選手コードを返す
            // getで取得すると配列インデックスから指定する必要がある
            // (firstで取得しない理由は念押しで複数件チェックを行なうため)
            return $result[0]->PLAYER_CODE;
        }
        else if($result->count() == 0){
            // 取得できなかった場合は空文字を返す
            return "";
        }

    }    

    /**
     * 選手マスタの最大コード取得
     */
    public function getMaxPlayerCode(){
        $result = M_PLAYER::max("PLAYER_CODE");

        return $result;
    }           

    /**
     * 選手マスタ簡易登録（キー情報だけ）
     */
    public function sinplifyInsertM_PLAYERS($pPlayerCode, $pPlayerName, $pCollegeCode){
        // 
        $result = 
        DB::table("M_PLAYERS")
        ->insert(
            ["PLAYER_CODE" => $pPlayerCode,
             "PLAYER_NAME" => $pPlayerName,
             "COLLEGE_CODE" => $pCollegeCode,
             "CREATED_AT" => date('Y-m-d H:i:s')
            ]);

        return $result;
    }    
}