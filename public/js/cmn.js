/**
 * 
 * 共通JavaScriptファイル
 * 
 */

/**
 * 対象コントロールの名称リスト
 */
var arrCtlName = {
    txtEntryCollege_Name   : "大学名"
   ,txtEntryCollege_Kana   : "大学名カナ"
}

/**
 * 選手マスタ登録フォームの名称リスト
 */
var arrPlayerCtlName = {
    txtEntryPlayer_Name   : "選手名"
   ,txtEntryPlayer_Kana   : "選手名カナ"
   ,txtEntryHighschool    : "出身高校"
   ,txtEntryCity          : "出身市町村"
}

/**
 * 定数：桁数判定モード1・等値
 */
const C_LENEQU  = 1;

/**
 * 定数：桁数判定モード2・不等値
 */
const C_LENNOT  = 2;

/**
 * 定数：桁数判定モード3・以上
 */
const C_LENMORE = 3;

/**
 * 定数：桁数判定モード4・以下
 */
const C_LENLESS = 4;

/**
 * 定数：画面モード・ノーマル
 */
const C_DSPNORMAL = "normal";

/**
 * 定数：画面モード・モーダル
 */
const C_DSPMODAL = "modal";

/**
 * 大学マスタ登録クリア
 */
var mstCollegeEntryclear = function(){
    document.getElementById("hidEntryCollege_Code").value = "";
    document.getElementById("txtEntryCollege_Name").value = "";
    document.getElementById("txtEntryCollege_Kana").value = "";
    document.getElementById("strSelectedInfo").innerHTML = "";
}

/**
 * 選手マスタ登録クリア
 */
var mstPlayerEntryclear = function(pForm){
    document.getElementById("hidEntryPlayer_Code").value = "";
    document.getElementById("txtEntryPlayer_Name").value = "";
    document.getElementById("txtEntryPlayer_Kana").value = "";
    document.getElementById("strSelectedInfo").innerHTML = "";
    // inputとtextareaの各要素を取得
    var lstInput = document.forms[pForm].querySelectorAll("input, textarea, select");    
    // ループ処理
    for (var i = 0; i < lstInput.length - 1; i++) {
        // テキストボックスの場合
        if(lstInput[i].type == "text"){
            i = i;
        }
    } 
}

/**
 * 大学マスタ_大学ラジオボタン選択
 */
var fcCngRadio = function(pIdx){
    // 登録フォームに選択値を設定
    document.getElementById("hidEntryCollege_Code").value = document.getElementById("rowCollegeCode" + pIdx).innerHTML;
    document.getElementById("txtEntryCollege_Name").value = document.getElementById("rowCollegeName" + pIdx).innerHTML;
    document.getElementById("txtEntryCollege_Kana").value = document.getElementById("rowCollegeKana" + pIdx).innerHTML;
    document.getElementById("chkOpen").checked = (document.getElementById("rowOpen" + pIdx).innerHTML == "オープン")    ;
    // 状態テキストを表示
    document.getElementById("strSelectedInfo").innerHTML = document.getElementById("rowCollegeCode" + pIdx).innerHTML + ":" 
                                                         + document.getElementById("rowCollegeName" + pIdx).innerHTML + "　を編集中";
}

/**
 * 選手マスタ_選手ラジオボタン選択
 */
var fcCngPlayerRadio = function(pIdx){
    // 登録フォームに選択値を設定
    document.getElementById("hidEntryPlayer_Code").value = document.getElementById("rowPlayerCode" + pIdx).innerHTML;
    document.getElementById("txtEntryPlayer_Name").value = document.getElementById("rowPlayerName" + pIdx).innerHTML;
    document.getElementById("txtEntryPlayer_Kana").value = document.getElementById("rowPlayerKana" + pIdx).innerHTML;
    // (jQueryを使わないで)入学年コンボボックスの値を指定
    document.getElementById("cmbYear").value = document.getElementById("hidRowAdmissionYear" + pIdx).value;
    // (jQueryを使って)大学コンボボックスや各種テキストの値を指定
    $("#cmbEntryCollege").val($("#hidRowCollegeCode" + pIdx).val());
    $("#cmbPref").val($("#hidRowPrefectureCode" + pIdx).val());
    $("#txtEntryCity").val($("#hidRowCity" + pIdx).val());
    $("#txtHighschool").val($   ("#rowHighschool" + pIdx).val());      
    // 状態テキストを表示
    document.getElementById("strSelectedInfo").innerHTML = document.getElementById("rowPlayerCode" + pIdx).innerHTML + ":" 
                                                         + document.getElementById("rowPlayerName" + pIdx).innerHTML + "　を編集中";
}

/**
 * 選手別記録登録_検索モード変更
 * @param {要素名} pElm 
 */
var fcCngDataType = function(pElm){
    if(pElm == "rdoTypeSect"){
        // 区間のラジオボタンをチェックした場合
        $("#cmbSect").prop("disabled", false);
        $("#cmbCollege").prop("disabled", true);
    }
    else if(pElm == "rdoTypeCollege"){
        // 大学のラジオボタンをチェックした場合
        $("#cmbSect").prop("disabled", true);
        $("#cmbCollege").prop("disabled", false);
    }
}

/**
 * 選手別記録登録_検索モード変更
 */
var fcSelRecPlayer = function(){
    if($("input[name=rdoTypeSectCollege]:checked").val() == "rdoTypeSect"){
        $("#hdnSelTypeStr").val($("[name=cmbSect] option:selected").text());
    }
    else if($("input[name=rdoTypeSectCollege]:checked").val() == "rdoTypeCollege"){
        $("#hdnSelTypeStr").val($("[name=cmbCollege] option:selected").text());
    }
}

/**
 * 検索_検索モード（区間・大学）チェックボックス変更
 * @param {要素名} pElm 
 */
var fcCheckDataType = function(pElm){
    if(pElm == "chkTypeSect"){
        // 区間のチェックを変更した場合
        // 区間のチェックがONかOFFか確認        
        if($("#"+pElm).prop("checked") == true){
            // 区間のチェックがONになった場合は、大学のチェックをOFFにする
            $("#chkTypeCollege").prop("checked", false);
            $("#cmbSect").prop("disabled", false);
            $("#cmbCollege").prop("disabled", true);            
        }
        else{
            // 区間のチェックがOFFになった場合は、区間を扱えなくする
            $("#cmbSect").prop("disabled", true);
        }

    }
    else if(pElm == "chkTypeCollege"){
        // 大学のチェックを変更した場合
        // 大学のチェックがONかOFFか確認        
        if($("#"+pElm).prop("checked") == true){
            // 大学のチェックがONになった場合は、区間のチェックをOFFにする
            $("#chkTypeSect").prop("checked", false);
            $("#cmbSect").prop("disabled", true);
            $("#cmbCollege").prop("disabled", false);            
        }
        else{
            // 大学のチェックがOFFになった場合は、大学を扱えなくする
            $("#cmbCollege").prop("disabled", true);
        }

    }
}

/**
 * 共通_年コンボボックス変更
 * @param {フォーム名} pForm 
 */
var fcCngYear = function(pForm){
    // 選手別記録テーブルの検索フォームの場合
    if(pForm.name == "searchform"){
        
    }
}

/**
 * 共通_入力内容チェック処理
 */
var fcChkEntryData = function(pMode = "normal") {
    // inputとtextareaの各要素を取得
    var lstInput = document.forms["mstCollegesEntryForm"].querySelectorAll("input, textarea"); 
    // ループ処理
    for (var j = 0; j < lstInput.length - 1; j++) {
        // テキストボックスの場合
        if(lstInput[j].type == "text"){
            // 空欄チェック
            if(fcChkBlank(lstInput[j].value) == false){
                // アラート表示
                alert("エラー：" + arrCtlName[lstInput[j].name] + "に値が設定されていません。");
                // 対象コントロールにフォーカス
                document.getElementById(lstInput[j].id).focus();
                return false;
            }
            // 禁則文字チェック
            if(fcChkIllegalChar(lstInput[j].value) == false){
                // アラート表示
                alert("エラー：" + arrCtlName[lstInput[j].name] + "に','が含まれています。','を削除してください。");
                // 対象コントロールにフォーカスし全選択
                document.getElementById(lstInput[j].id).focus();
                return false;
            }  
            // 半角入力チェック
            // 大学名カナの場合のみ
            if(lstInput[j].name == "txtEntryCollege_Kana"){            
                if(fcChk1bKana(lstInput[j].value) == false){
                    // アラート表示
                    alert("エラー：" + arrCtlName[lstInput[j].name] + "には半角カナのみ入力可能です。");
                    // 対象コントロールにフォーカス
                    document.getElementById(lstInput[j].id).select();
                    return false;
                }
            }
            // 桁数チェック
            // 大学名の場合
            if(lstInput[j].name == "txtEntryCollege_Name"){
                let len = 16;
                let lenmore = len + 1;
                if(fcChkLength(lstInput[j].value, lenmore, C_LENMORE) == false){
                    // アラート表示
                    alert("エラー：" + arrCtlName[lstInput[j].name] + "には" + len + "桁を超える入力はできません。");
                    // 対象コントロールにフォーカスし全選択
                    document.getElementById(lstInput[j].id).select();
                    return false;
                }
            }
            // 大学名カナの場合
            if(lstInput[j].name == "txtEntryCollege_Kana"){
                let len = 32;
                let lenmore = len + 1;
                if(fcChkLength(lstInput[j].value, lenmore, C_LENMORE) == false){
                    // アラート表示
                    alert("エラー：" + arrCtlName[lstInput[j].name] + "には" + len + "桁を超える入力はできません。");
                    // 対象コントロールにフォーカスし全選択
                    document.getElementById(lstInput[j].id).select();
                    return false;
                }
            }                                
        }
    }

    // 登録確認
    var conf = window.confirm("大学名：" + document.getElementById("txtEntryCollege_Name").value + "\r"
                            + "カナ名：" + document.getElementById("txtEntryCollege_Kana").value + "\r"
                            + "を登録します。よろしいですか？");
    if(conf == true){
        //
        if(pMode == C_DSPMODAL){
            // ajaxで登録
            insertM_COLLEGESWithAjax();
        }
        else      {
            // 登録処理へ
            document.forms["mstCollegesEntryForm"].action="updateM_COLLEGES";
            document.forms["mstCollegesEntryForm"].method="post";
            document.forms["mstCollegesEntryForm"].submit();
        }
        return true;
    } 
    else{
        // 登録キャンセル
        return false;
    }
}

/**
 * 選手マスタ_入力内容チェック処理
 */
var fcChkPlayerData = function(){
    // inputとtextareaの各要素を取得
    var lstInput = document.forms["mstPlayersEntryForm"].querySelectorAll("input, textarea"); 
    // ループ処理
    for (var j = 0; j < lstInput.length - 1; j++) {
        // テキストボックスの場合
        if(lstInput[j].type == "text"){
            // 空欄チェック(選手名のみ)
            if(lstInput[j].name == "txtEntryPlayer_Name"
            && (fcChkBlank(lstInput[j].value)) == false ){
                // アラート表示
                alert("エラー：" + arrPlayerCtlName[lstInput[j].name] + "に値が設定されていません。");
                // 対象コントロールにフォーカス
                document.getElementById(lstInput[j].id).focus();
                return false;
            }
            // 禁則文字チェック
            if(fcChkIllegalChar(lstInput[j].value) == false){
                // アラート表示
                alert("エラー：" + arrPlayerCtlName[lstInput[j].name] + "に','が含まれています。','を削除してください。");
                // 対象コントロールにフォーカスし全選択
                document.getElementById(lstInput[j].id).focus();
                return false;
            }
            // 半角入力チェック
            // 選手名カナの場合のみ
            if(lstInput[j].name == "txtEntryPlayer_Kana"){
                if(fcChk1bKana(lstInput[j].value) == false){
                    // アラート表示
                    alert("エラー：" + arrPlayerCtlName[lstInput[j].name] + "には半角カナのみ入力可能です。");
                    // 対象コントロールにフォーカス
                    document.getElementById(lstInput[j].id).select();
                    return false;
                }
            }
            // 桁数チェック
            // 選手名の場合
            if(lstInput[j].name == "txtEntryPlayer_Name"
            || lstInput[j].name == "txtEntryPlayer_Kana"
            || lstInput[j].name == "txtEntryHighschool"){
                let len = 32;
                let lenmore = len + 1;
                if(fcChkLength(lstInput[j].value, lenmore, C_LENMORE) == false){
                    // アラート表示
                    alert("エラー：" + arrPlayerCtlName[lstInput[j].name] + "には" + len + "桁を超える入力はできません。");
                    // 対象コントロールにフォーカスし全選択
                    document.getElementById(lstInput[j].id).select();
                    return false;
                }
            }
            // 桁数チェック
            // 出身市町村の場合
            if(lstInput[j].name == "txtEntryCity"){
                let len = 16;
                let lenmore = len + 1;
                if(fcChkLength(lstInput[j].value, lenmore, C_LENMORE) == false){
                    // アラート表示
                    alert("エラー：" + arrPlayerCtlName[lstInput[j].name] + "には" + len + "桁を超える入力はできません。");
                    // 対象コントロールにフォーカスし全選択
                    document.getElementById(lstInput[j].id).select();
                    return false;
                }
            }
        }
    }
    // 登録確認
    var conf = window.confirm("選手名：" + document.getElementById("txtEntryPlayer_Name").value + "\r"
                            + "カナ名：" + document.getElementById("txtEntryPlayer_Kana").value + "\r"
                            + "を登録します。よろしいですか？");
    if(conf == true){
        // 登録処理へ
        document.forms["mstPlayersEntryForm"].action="updateM_PLAYERS";
        document.forms["mstPlayersEntryForm"].method="post";
        document.forms["mstPlayersEntryForm"].submit();
        return true;
    } 
    else{
        // 登録キャンセル
        return false;
    }    
}

/***************
 * 共通_空欄チェック処理
 **************/
var fcChkBlank = function(text) {
    // テキストの値が空欄かチェック
    if(text == ""){
        // エラーを返す
        return false;
    }
    return true;
}

/***************
 * 共通_禁止文字チェック
 **************/
var fcChkIllegalChar = function(text) {
    // テキストの値チェック
    if(text.indexOf(",") > -1){
        // エラーを返す
        return false;
    }
    return true;
}

/***************
 * 共通_数値入力Name
 **************/
var fcChkNumber = function(text) {
    // 数値でないかをチェック
    if(isNaN(text) == true){
            // エラーを返す
            return false;        
    }
    return true;
}

/***************
 * 共通_電話番号入力チェック
 **************/
var fcChkTelNumber = function(text) {
    // ハイフンを消去
    let repTxt = text.replace("-","");
    // ハイフン以外が数値でないかをチェック
    if(isNaN(repTxt) == true){
            // エラーを返す
            return false;        
    }
    return true;
}

/***************
 * 共通_全角入力チェック
 **************/
var fcChk2Byte = function(text) {
    // 全角でないかをチェック
    if(text.match(/[^A-Z^a-z\d\-\_]/) != null){
            // エラーを返す
            return false;        
    }
    return true;
}

/***************
 * 共通_半角カナ限定入力チェック
 **************/
var fcChk1bKana = function(text) {
    // 半角でないかをチェック
    if(!text.match(/^[ｦ-ﾟ]*$/) == true){
            // エラーを返す
            return false;        
    }
    return true;
}

/***************
 * 共通_桁数判定チェック
 **************/
var fcChkLength = function(text, length, mode) {
    // 判断モード確認
    switch(mode){
        case C_LENEQU:
            // 桁が一致すればエラー
            if(text.length == length){
                // エラーを返す
                return false;        
            }
            break;
        case C_LENNOT:
            // 桁が異なればエラー
            if(text.length != length){
                // エラーを返す
                return false;        
            }
            break;
        case C_LENMORE:
            // 桁が指定以上ならエラー
            if(text.length >= length){
                // エラーを返す
                return false;   
            }     
            break;            
        case C_LENLESS:
            // 桁が指定以下ならエラー
            if(text.length <= length){
                // エラーを返す
                return false;   
            }     
            break;
    }
    return true;
}

/**
 * 共通・タイム入力値妥当性チェック
 * @param チェック対象要素
 * @return true:正常 false:以上
 */
var fcChkTimeRecord = function(elm){
    let tr = elm.value;
    // 空欄の場合は問題なしとする
    if(tr == ""){
        return true;
    }

    // 半角数字と:以外が入力されている場合
    if(tr.match(/[^0-9|:]/g) != null){
        window.alert("タイムのフォーマットが誤っています。半角数字かコロンのみ使用可能です。");
        // 対象コントロールにフォーカス(フォーカス前にonblurイベントを一時的に外す)
        setTimeout(function(){ 
            elm.focus(); 
            elm.select(); 
        }, 1); 
        // エラーを返す
        return false;  
    }

    // 時刻変換
    let newTr;
    let arrTr;
    let tr_h;
    let tr_m;
    let tr_s;    
    // :が入力されている場合
    if(tr.match(/[:]/) != null){
        arrTr = tr.split(":");
        // 配列の要素数で設定先の値を判断
        if(arrTr.length == 2){
            // 分と秒を設定
            tr_m = arrTr[0];
            tr_s = arrTr[1];            
        }
        else if(arrTr.length == 3){
            // 時分秒を設定
            tr_h = arrTr[0];
            tr_m = arrTr[1];
            tr_s = arrTr[2];
        } 
    }
    else{
        // :が入力されていない場合
        newTr = tr;
        tr_h = Math.floor(newTr / 10000);
        tr_m = Math.floor(newTr % 10000 / 100);
        tr_s = newTr % 10000 % 100;
    }


    // 時分秒ごとの妥当性チェック
    if(tr_h < 0 || tr_h > 100 
    || tr_m < 0 || tr_m > 60
    || tr_s < 0 || tr_s > 60){
        window.alert("タイムのフォーマットが誤っています。有効な時間をhh:mm:ss形式で入力してください。");
        // 対象コントロールにフォーカス(フォーカス前にonblurイベントを一時的に外す)
        setTimeout(function(){ 
            elm.focus(); 
            elm.select(); 
        }, 1); 
        // エラーを返す
        return false;  
    }

    // コロンつきタイムに再編集
    elm.value = fcPadZero(tr_h, 2) + ":" + fcPadZero(tr_m, 2) + ":" + fcPadZero(tr_s, 2);

    // 問題なし
    return true;
}

/**
 * ゼロ埋め関数
 * @param {*ゼロ埋め対象値} pInt 
 * @param {*ゼロ埋め桁数} pKeta 
 */
var fcPadZero = function(pInt, pKeta){
    // 設定値と桁数に数値が入力されているかどうかチェック
    if(fcChkNumber(pInt) == false
    || fcChkNumber(pKeta) == false){
        // 数値でない場合、そのままの値を返す
        return pInt;
    }    

    // 0埋め用の文字列作成
    strZero = "";
    for(var i = 1; i <= pKeta; i++){
        strZero = strZero + "0";
    }

    // 指定の桁数で0埋めして返す
    return ( strZero + pInt ).slice( pKeta * -1 );

}

/**
 * 新規行追加
 */
var fcMakeInputRowCollege = function() {
    // テーブル
    let tgtElm = document.getElementById("recYearList");
    // 行カウントを取得
    let rowCnt = document.getElementById("hdnRowCnt").value;
    rowCnt = parseInt(rowCnt) + 1;
    // HTML作成
    let insHTML = "<tr id=\"row" + rowCnt + "\">"
                + "    <td><input type=\"checkbox\" id=\"rowDel" + rowCnt + "\" name=\"rowDel" + rowCnt + "\" value=\"1\"></td>"
                // + "    <td><input type=\"text\" id=\"rowCmbCollegeCode" + rowCnt + "\" name=\"rowCmbCollegeCode" + rowCnt + "\"></td>"
                + "    <td><div id=\"rowColleges" + rowCnt + "\" name=\"rowColleges" + rowCnt + "\"></div></td>"
                + "    <td><input type=\"text\" id=\"rowTimeRecord" + rowCnt + "\" name=\"rowTimeRecord" + rowCnt + "\" onblur=\"fcChkTimeRecord(this)\"></td>"
                + "    <td><input type=\"checkbox\" id=\"rowOpen" + rowCnt + "\" name=\"rowOpen" + rowCnt + "\" value=\"1\"></td>"
                + "    <td><input type=\"checkbox\" id=\"rowDefault" + rowCnt + "\" name=\"rowDefault" + rowCnt + "\" value=\"1\"></td>"
                + "    <td><input type=\"checkbox\" id=\"rowSeed" + rowCnt + "\" name=\"rowSeed" + rowCnt + "\" value=\"1\"></td>"
                + "    <td><input type=\"textarea\" id=\"rowMemo" + rowCnt + "\" name=\"rowMemo" + rowCnt + "\"></td>"
                + "    <td><input type=\"hidden\" id=\"rowCollegeCode" + rowCnt + "\" name=\"rowCollegeCode" + rowCnt + "\" value=\"\"></td>"
                + "</tr>";
    // HTMLに追加
    tgtElm.insertAdjacentHTML("beforeend", insHTML);
    // テーブルカウント加算
    document.getElementById("hdnRowCnt").value = rowCnt;
    // 大学名コンボボックス作成
    getM_COLLEGESWithAjax();    

}

/**
 * 年別記録テーブル登録内容チェック処理
 */
var fcChkRecYear = function() {
    // 削除チェック用変数
    let arrDelList = [];
    let elmDelLbl;
    // 登録データの行数分ループ
    for(var i = 1; i >= 0; i++){
        // 存在しない行ならループ終了
        if(document.getElementById("rowCollegeCode" + i) == null){
            break;
        }

        // 既存行の削除チェック
        if(document.getElementById("rowCmbCollegeCode" + i) == null
        && document.getElementById("rowDel" + i).checked == true){
            // 大学名を取得
            elmDelLbl = document.querySelector("label[for=\"rowCollegeCode" + i + "\"");
            arrDelList.push(elmDelLbl.textContent);  
        }
        
        // 新規入力かつ、削除対象でない行の場合
        if(document.getElementById("rowCmbCollegeCode" + i) != null
        && document.getElementById("rowDel" + i).checked != true){
            // 重複している大学がないか、既存・新規行すべてを対象に確認
            for(var iCode = 1; iCode > 0; iCode++){  
                // 存在しない行ならループ終了
                if(document.getElementById("rowCollegeCode" + iCode) == null){
                    break;
                } 
                // 同じ行ならスキップ
                if(i == iCode){
                    continue;
                }                 
                // 対象行タイムが既存か判断
                if(document.getElementById("rowCmbCollegeCode" + iCode) != null){                 
                    // 対象行が新規行の場合              
                    if(document.getElementById("rowCmbCollegeCode" + i).value == document.getElementById("rowCmbCollegeCode" + iCode).value){
                        window.alert("同じ大学を選択しておるぞ");
                        // 対象コントロールにフォーカス
                        document.getElementById("rowCmbCollegeCode" + i).focus();                        
                        return false;
                    }
                }
                else {
                    // 対象行が既存行の場合 
                    if(document.getElementById("rowCmbCollegeCode" + i).value == document.getElementById("rowCollegeCode" + iCode).value){                        
                        window.alert("同じ大学を選択しておるぞ");
                        // 対象コントロールにフォーカス
                        document.getElementById("rowCmbCollegeCode" + i).focus();                          
                        return false;
                    }
                }
            }
        }

        // タイムが入力されているか
        if(document.getElementById("rowTimeRecord" + i).value == null){
            window.alert("タイムが入力されておらんぞ");
            // 対象コントロールにフォーカス
            document.getElementById("rowTimeRecord" + i).focus();                          
            return false;
        }

        // タイムの入力値が妥当か        
        if(fcChkTimeRecord(document.getElementById("rowTimeRecord" + i)) == false){                       
            return false;
        }

    }
    try{
    // 既存行の削除を1件以上行う場合
    strDelList = "";    
    if(arrDelList.length > 0){
        // 削除確認用の文字列作成
        strDelList = "\rまた、既存のデータのうち、\r";
        arrDelList.forEach(function(val){
            strDelList = strDelList + "　・" + val + "\r";
        });        
        strDelList = strDelList + "のデータを削除します。" + "\r"
                   + "一度削除するとデータは元に戻せません。\r";
    }
    }catch(e){
        console.log(e)
    }

    // 登録確認
    var conf = window.confirm(document.getElementById("hdnSelYear").value + "年のデータを登録します。\r"
                            + strDelList + "\r"
                            + "よろしいですか？");
    if(conf == true){
        // 登録処理へ
        document.forms["updRecYearForm"].action="\\update\\recYear\\update";
        document.forms["updRecYearForm"].method="post";
        document.forms["updRecYearForm"].submit();
        return true;
    } 
    else{
        // 登録キャンセル
        return false;
    }    
}

/**
 * 選手別記録テーブル登録内容チェック処理
 */
var fcChkRecPlayer = function() {
    // 削除チェック用変数
    let arrDelList = [];
    // 新規入力チェック用変数
    let arrInsList = [];    
    let elmDelLbl;
    let selType;
    let hen;
    // モード判定（区間・大学）
    if(document.getElementById("hdnSelType").value == "rdoTypeSect"){
        // 区間で検索した場合は大学コードをキーとする
        selType = "CollegeCode";
    }
    else{
        // 大学で検索した場合は区間コードをキーとする
        selType = "SectionCode";
    }
    // 登録データの行数分ループ（要素のidの末尾連番でチェック）
    for(var i = 1; i >= 0; i++){
        // 行の存在確認
        if(document.getElementById("row"+ selType + i) == null){
            // 存在しない=全行完了とみなしbreakする
            break;
        }
       
        // // 既存行の削除チェック 
        // if((document.getElementById("rowPlayerCode" + i) != "")
        // && (document.getElementById("rowPlayerName" + i).value == "" && document.getElementById("rowTimeRecord" + i).value == "")){
        //     // 選手名を取得
        //     elmDelLbl = document.querySelector("label[for=\"rowPlayerCode" + i + "\"");
        //     arrDelList.push(elmDelLbl.textContent);  
        // }

        // 選手名、タイムが片方しか入力されていない場合
        if((document.getElementById("rowPlayerName" + i).value == "" && document.getElementById("rowTimeRecord" + i).value != "")
        || (document.getElementById("rowPlayerName" + i).value != "" && document.getElementById("rowTimeRecord" + i).value == "")){
            window.alert("選手名、タイムが両方入力されておらんぞ。まったく入力しないか、両方入力するかのいずれかにしたまえ。");
            // 対象コントロールにフォーカス
            document.getElementById("rowTimeRecord" + i).focus();                          
            return false;
        }
        // 選手名が入力されていれば、選手名から選手を検索
        // ajaxがうまくできないので一旦停止。サーバ側で淡々と登録していく
        // if(document.getElementById("rowPlayerName" + i).value != ""){
        //     // 選手名を検索
        //     hen = setTimeout(wpSearchM_PLAYERSWithAjax(i), 10);
        //     window.alert("hen"+hen);
        //     if(hen > 0){
        //         // 存在しない場合は新規登録対象とする
        //         // TODO:区間もしくは大学名を取得（selTypeで判断）
        //         // TODO:選手名をテキストボックスから取得
        //         // TODO:取得した上記値をarrInsListにpush
        //         arrInsList.push(i);
        //     }
        // }

        // タイムの入力値が妥当か        
        if(fcChkTimeRecord(document.getElementById("rowTimeRecord" + i)) == false){                       
            return false;
        }

    }

    // ajaxでデータチェック
    // 一旦、淡々とサーバー側で新規選手登録をする仕様とする
    // var objPrm = new Promise((resolve, reject) => {
	// 	searchM_PLAYERSWithAjax(idx);
    // })
    
    try{
    // 既存行の削除を1件以上行う場合
    strInsList = "";    
    if(arrInsList.length > 0){
        // 削除確認用の文字列作成
        arrInsList = "\rまた、新規の選手データとして\r";
        arrInsList.forEach(function(val){
            strInsList = strInsList + "　・" + val + "\r";
        });        
        strInsList = strInsList + "のデータを登録します。" + "\r";
        
    }
    }catch(e){
        console.log(e)
    }

    // 登録確認
    var conf = window.confirm(document.getElementById("hdnSelYear").value + "年のデータを登録します。\r"
                            + strInsList + "\r"
                            + "よろしいですか？");
    if(conf == true){
        // 登録処理へ
        document.forms["updRecPlayerForm"].action="\\update\\recPlayer\\update";
        document.forms["updRecPlayerForm"].method="post";
        document.forms["updRecPlayerForm"].submit();
        return true;
    } 
    else{
        // 登録キャンセル
        return false;
    }    
}

/**
 * モーダル画面作成
 */
var makeModal = function(){
    $(".modal").fadeIn();
    return false;
}

/**
 * モーダル画面を閉じる
 */
var closeModal = function(){
    $(".modal").fadeOut();
    return false;
}