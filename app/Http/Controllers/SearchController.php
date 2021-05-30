<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;    // 追加した参照
use Illuminate\Support\Facades\DB;      // DB操作するため参照追加
use App\D_ENTRY_COLLEGE;                // 追加した参照
use App\Models\CommonParts;             // 共通パーツクラス
use App\Models\CommonDB;                // 共通DB検索クラス

////////////////////////
//
// 箱根DB：検索クラス
//
////////////////////////
class SearchController extends Controller
{
    // 共通クラス
    protected $cmnParts;

    // 検索：メイン
    public function searchMain(Request $request){

        // 年度コンボボックス作成
        $cmbYear = CommonParts::createYearCmbBox();
        $cmbSect = CommonParts::createSectCmbBox();
        // 大学マスタは全大学を表示（ページネーション指定なし）   
        $MCL = CommonDB::searchM_COLLEGES($request, "");          

        return View::make("/search/searchMain", ['cmbYear' => $cmbYear,
                                                 "cmbSect" => $cmbSect,
                                                 "mstCollegesList" => $MCL]);
    }

    // 検索：年別検索
    public function searchExec(Request $request){

        // Input::get(name)でフォームの各値を取得できる
        // 年指定か確認
        if($request->has("submit")){
            $selYear = $request->get("cmbYear");
        }
        else{
            $selYear = "";
        };   

        // 検索タイプを取得
        $selType = "";
        if($request->get("chkTypeSect") != ""){
            $selType = $request->get("chkTypeSect");
        }
        else if($request->get("chkTypeCollege") != ""){
            $selType = $request->get("chkTypeCollege");
        }
        
        // DB検索
        $rowCnt = 0;
        $results = CommonDB::searchD_ENTRY_COLLEGES($request, $rowCnt, $selType);

        // 年度コンボボックス作成
        $cmbYear = CommonParts::createYearCmbBox();
        $cmbSect = CommonParts::createSectCmbBox();
        // 大学マスタは全大学を表示（ページネーション指定なし）   
        $MCL = CommonDB::searchM_COLLEGES($request, "");         
        
        // 元ページ返却
        return View::make("/search/searchMain", ["cmbYear" => $cmbYear, 
                                                 "cmbSect" => $cmbSect,
                                                 "mstCollegesList" => $MCL,
                                                 "selYear" => $selYear,
                                                 "selType" => $selType,
                                                 "results" => $results]);

    }

    // 検索：チャート
    public function makeChart(Request $request){   
        // カウント初期設定
        $cnt = 0;

        // 年取得
        $chartYear = 1900;
        if($request->has("cmbYear")){
            $chartYear = $request->get("cmbYear");
        }

        // チャート用データ取得
        $myChart = $this->searchChartDataByYear($request, $chartYear, $cnt);
        $myChartTest;

        // チャートタイプ設定
        $chtType = "line";

        // チャートのlabelを設定
        $labels = array();
        foreach($myChart as $rowLabel){
            $labels = $labels + array((int)$rowLabel->SECTION_CODE - 1 => $rowLabel->SECTION_NAME);
        }
        
        // チャートのdatasetsを設定
        $dataset = array();
        $idxColleges = 0;
        $prevCode = "";
        $data;
        // 各レコードをループ
        foreach ($myChart as $idx => $rowData) {
            // 前の大学と比較が不一致か
            if($prevCode != $rowData->COLLEGE_CODE){
                // 最初の行でなければインデックスを加算
                if($idx != 0){
                    $idxColleges++;             
                };
                // 前データの大学コード比較用変数を更新
                $prevCode = $rowData->COLLEGE_CODE;
                // 新しいデータ配列を新規作成
                $dataset[$idxColleges] = array();
                $dataset[$idxColleges] = $dataset[$idxColleges] + array("label" => $rowData->COLLEGE_NAME);
                $dataset[$idxColleges] = $dataset[$idxColleges] + array("borderColor" => $this->setChartRGBA($idxColleges, 1));
                $dataset[$idxColleges] = $dataset[$idxColleges] + array("backgroundColor" => $this->setChartRGBA($idxColleges, 0.2));
                $dataset[$idxColleges] = $dataset[$idxColleges] + array("borderWidth" => 1 );
                $dataset[$idxColleges] = $dataset[$idxColleges] + array("lineTension" => 0 );
                $dataset[$idxColleges] = $dataset[$idxColleges] + array("fill" => false );
                $dataset[$idxColleges] = $dataset[$idxColleges] + array("pointHoverRadius" => 5 );                
                // 新しい順位データ用配列を作成
                $data = array();
                $dataset[$idxColleges] = $dataset[$idxColleges] + array("data" => $data );                
            }
            // 順位データを追加
            if($rowData->RANKING == 0){
                // 順位が0ならデータがないとみなし、NULLをセット
                $dataset[$idxColleges]["data"] = $dataset[$idxColleges]["data"] + array((int)$rowData->SECTION_CODE - 1 => NULL);
            }
            else{
                $dataset[$idxColleges]["data"] = $dataset[$idxColleges]["data"] + array((int)$rowData->SECTION_CODE - 1 => $rowData->RANKING);
            }
        }

        //出力結果にセット
        $myChartTest = ["type" => $chtType,
                        "data" => [
                            "labels" => $labels,
                            "datasets" => $dataset
                        ],
                        "options" => [
                            "scales" => [
                                "yAxes" => [[
                                    "ticks" => [
                                        "reverse" => true,
                                        "max" => 21,
                                        "min" => 1,
                                        "stepSize" => 1
                                    ]
                                ]]
                            ],
                            "animation" => [
                                "easing" => "easeOutQuart"
                            ],
                            "responsive" => true,
                            "maintainAspectRatio" => false
                        ]
        ];    
        
        // 年度コンボボックス作成
        $cmbYear = CommonParts::createYearCmbBox();        

        //return var_dump($myChartTest);
        return View::make("/search/searchChart",  ["myChart" => json_encode($myChartTest), "cmbYear" => $cmbYear]);        

        // 以下、サンプル
        // $myChart = ["type" => $chtType,
        //             "data" => [
        //                 "labels" => ["1区", "2区", "3区", "4区", "5区", "6区", "7区", "8区", "9区", "10区"],
        //                 "datasets" => [[
        //                     "label" => ["青山学院大学"],
        //                     "data" => [12, 9, 3, 5, 2, 3, 2, 1, 1, 1],
        //                     "backgroundColor" => [
        //                          "rgba(255, 99, 132, 0.2)"
        //                     //     "rgba(54, 162, 235, 0.2)",
        //                     //     "rgba(255, 206, 86, 0.2)",
        //                     //     "rgba(75, 192, 192, 0.2)",
        //                     //     "rgba(153, 102, 255, 0.2)",
        //                     //     "rgba(255, 159, 64, 0.2)"
        //                     ],
        //                     "borderColor" => [
        //                         "rgba(255, 99, 132, 1)"
        //                         // "rgba(255, 99, 132, 1)",
        //                         // "rgba(54, 162, 235, 1)",
        //                         // "rgba(255, 206, 86, 1)",
        //                         // "rgba(75, 192, 192, 1)",
        //                         // "rgba(153, 102, 255, 1)",
        //                         // "rgba(255, 159, 64, 1)"
        //                     ],
        //                     "pointRadius" => 5,       
        //                     "pointHoverRadius" => 10,      
        //                     "pointHoverBackgroundColor" => "rgba(255, 99, 132, 0.5)",
        //                     "pointHoverBorderColor" => "rgba(224, 90, 120, 1)",
        //                     "borderWidth" => [1],
        //                     "lineTension" => [0],
        //                     "fill" => false
        //                 ],
        //                 [
        //                     "label" => ["駒澤大学"],
        //                     "data" => [5, 2, 1, 1, 1, 1, 1, 2, 4, 3],
        //                     "backgroundColor" => [
        //                          "rgba(153, 102, 255, 0.2)"
        //                     ],
        //                     "borderColor" => [
        //                         "rgba(153, 102, 255, 1)"
        //                     ],
        //                     "pointRadius" => 5,
        //                     "pointHoverRadius" => 10,   
        //                     "pointHoverBackgroundColor" => "rgba(153, 102, 255, 0.5)",
        //                     "pointHoverBorderColor" => "rgba(138, 92, 224, 1)",
        //                     "borderWidth" => [1],
        //                     "lineTension" => [0],
        //                     "fill" => false
        //                 ],
        //                 [
        //                     "label" => ["テスト大学"],
        //                     "data" => [6, 7, 10, 14, 11, 9, 6, 7, 9, 11],
        //                     "backgroundColor" => [
        //                         "rgba(54, 162, 235, 0.2)"
        //                     ],
        //                     "borderColor" => [
        //                         "rgba(54, 162, 235, 1)"
        //                     ],
        //                     "borderDash" => [2, 3],
        //                     "pointStyle" => "star",
        //                     "pointRadius" => 5,
        //                     "pointBorderColor" => "rgba(104, 162, 255, 1)",
        //                     "pointHoverRadius" => 25,
        //                     "borderWidth" => [3],
        //                     "lineTension" => [0],
        //                     "hoverBorderColor" => "rgba(226, 128, 0, 1)",
        //                     "fill" => false                            
        //                 ]] 
        //             ],
        //             "options" => [
        //                 "scales" => [
        //                     "yAxes" => [[
        //                         "ticks" => [
        //                             "reverse" => true,
        //                             "max" => 21,
        //                             "min" => 1

        //                         ]
        //                     ]]
        //                 ],
        //                 "animation" => [
        //                     "easing" => "easeOutQuart"
        //                 ]
        //             ]
        // ];
        // return View::make("/search/searchChart",  ["myChart" => json_encode($myChart)]);
    }

    /**
     * 選手別記録テーブル取得
     */
    public function searchChartDataByYear(request $request, $pYear, &$pRowCnt){
        // https://teratail.com/questions/196063
        // "複雑なSQL問い合わせで、SQLがわかっている場合は、無理にクエリビルダーのメソッドチェーンを繋げる必要はない"
        $chtData = DB::select("SELECT EC_SECT.TIME_RECORD AS COLLEGE_RECORD
                                    , EC_SECT.COLLEGE_CODE
                                    , MC.COLLEGE_NAME
                                    , EC_SECT.SECTION_CODE
                                    , EC_SECT.SECTION_NAME
                                    , :year1 YEAR_CODE
                                    , COUNT(EP.TIME_RECORD) AS RANKING
                                    , EP.PLAYER_CODE
                                    , MP.PLAYER_NAME
                                    , EP.TIME_RECORD AS PLAYER_RECORD
                                 FROM (SELECT EC.COLLEGE_CODE
                                            , EC.TIME_RECORD
                                            , EC.YEAR_CODE
                                            , sect.SECTION_CODE
                                            , sect.SECTION_NAME
                                         FROM d_entry_colleges AS EC
                                            , sections AS sect
                                        WHERE EC.YEAR_CODE = :year2) AS EC_SECT
                                      LEFT JOIN (SELECT * 
                                                   FROM d_entry_players AS EP
                                                  WHERE EP.YEAR_CODE = :year3) AS EP
                                      ON EC_SECT.COLLEGE_CODE = EP.COLLEGE_CODE
                                      AND EC_SECT.SECTION_CODE = EP.SECTION_CODE
                                      LEFT JOIN (SELECT *
                                                   FROM d_entry_players AS EP2
                                                  WHERE EP2.YEAR_CODE = :year4) AS EP2
                                      ON EP.TIME_RECORD >= EP2.TIME_RECORD
                                      AND EP.SECTION_CODE = EP2.SECTION_CODE
                                      LEFT JOIN m_colleges AS MC
                                      ON EC_SECT.COLLEGE_CODE = MC.COLLEGE_CODE
                                      LEFT JOIN m_players AS MP
                                      ON EP.PLAYER_CODE = MP.PLAYER_CODE
                                GROUP BY EC_SECT.TIME_RECORD
                                       , EC_SECT.COLLEGE_CODE
                                       , MC.COLLEGE_NAME
                                       , EC_SECT.SECTION_NAME
                                       , EC_SECT.SECTION_CODE
                                       , EP.PLAYER_CODE
                                       , MP.PLAYER_NAME
                                       , EP.TIME_RECORD
                                ORDER BY EC_SECT.TIME_RECORD
                                       , EC_SECT.COLLEGE_CODE
                                       , EC_SECT.SECTION_CODE
                                       , EP.TIME_RECORD"
                            , ["year1" => $pYear
                             , "year2" => $pYear
                             , "year3" => $pYear
                             , "year4" => $pYear]);

        // 行数セット
        $pRowCnt = count($chtData);

        // データセットを返却
        return $chtData;

    } 
    
    private function setChartRGBA($pIdx, $pAlpha){
        // TODO:大学コードごとの色判定
        // TODO:SQLで大学マスタから色を取得してくるのが良いかも
        // インデックスで色判定
        $idx = $pIdx % 24;
        $r = 0;
        $g = 0;
        $b = 0;
        // R:(i<8,16<i)インデックス-12の絶対値-4の値*32
        if($idx < 8 || $idx > 16){
            $r = (abs($idx - 12) - 4) * 32;
            // 最大値を超える場合、最大値を設定
            if(intdiv($r, 255) > 0){
                $r = 255;
            }
        }
        // G:(0<i<16)8からインデックス-8の絶対値を引いた値*32
        if($idx > 0 && $idx < 16){
            $g = (8 - abs($idx - 8)) * 32;
            // 最大値を超える場合、最大値を設定
            if(intdiv($g, 255) > 0){
                $g = 255;
            }
        }
        // B:(8<i<24)8からインデックス-16の絶対値を引いた値*32
        if($idx > 8 && $idx < 24){
            $b = (8 - abs($idx - 16)) * 32;
            // 最大値を超える場合、最大値を設定
            if(intdiv($b, 255) > 0){
                $b = 255;
            }
        }     
        
        // 返却する文字列を作成
        return "rgba(".$r.", ".$g.", ".$b.", ".$pAlpha.")";

    }

}
