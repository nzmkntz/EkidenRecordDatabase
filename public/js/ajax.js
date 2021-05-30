/**
 * 
 * ajax処理専用ファイル
 * 
 */

/**
 * 大学マスタデータ取得・コンボボックス作成
 */
 function getM_COLLEGESWithAjax(){
	// 大学マスタ取得
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
	$.ajax({
		type        : "get",
	    url         : "/update/ajax/getM_COLLEGES",
		// dataType    : "json",
		dataType    : "text",
		async       : "false",
		data        : {}
	})
	// 通信成功
	.done(function(data) {
		// テーブル行数を取得
		var rowCnt = $('input:hidden[name="hdnRowCnt"]').val();
		// 忸怩たる思いで文字列操作にてコンボボックスを作成する。いつかはjsonで。。
		var optidx = 0;
		var coronidx = 0;
		var commaidx = 0;
		var str = data;
		var code = "";
		var name = "";
		var part = "";
		var htm = "<select id=\"rowCmbCollegeCode" + rowCnt + "\" name=\"rowCmbCollegeCode" + rowCnt + "\">";
		while(true){
			// カンマ区切りの"code:name"のデータセットを取得していく
			optidx = optidx + 1;
			commaidx = str.indexOf(",");
			if(commaidx == -1){
				commaidx = str.length;
			}			
			part = str.substr(0, commaidx);
			str = str.substr(commaidx + 1, str.length - 1);
			coronidx = part.indexOf(":");
			code = part.substr(0, coronidx);
			name = part.substr(coronidx + 1, part.length - 1);
			htm = htm + "    <option name=\"optRCCC" + code + "\" value=\"" + code +"\">" + name + "</option>\n";
			if(str.length == 0){
				break;
			}
		}
		htm = htm + "</select>";
		$("div#rowColleges" + rowCnt).append(htm);	
		// テスト用
		// window.alert(htm);			
	})
	// 通信失敗
	.fail(function(jqXHR, textStatus, errorThrown) {
		window.alert("失敗");
		console.log("ajax通信に失敗しました");
		console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
		console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
		console.log("errorThrown    : " + errorThrown.message); // 例外情報
		return;
	})
	// 事後処理
	.always(function() {

	});    
}

/**
 * 大学マスタ登録
 */
function insertM_COLLEGESWithAjax(){
	// 大学マスタ取得
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	});
	try{
	$.ajax({
		type        : "post",
	    url         : "/update/ajax/insertM_COLLEGES",
		dataType    : "json",
		async       : "false",
		data        : {
			txtEntryCollege_Name : $("#txtEntryCollege_Name").val(),
			txtEntryCollege_Kana : $("#txtEntryCollege_Kana").val()
		}
		// 登録前の値を確認する場合
		//,
		// beforeSend: function ( jqXHR, settings ) {
		// 	alert( settings.type ); 
		// 	alert($("#txtEntryCollege_Name").val() + $("#txtEntryCollege_Kana").val());
		// }		
	})
	// 通信成功
	.done(function(data) {
		// テキストボックスをクリア
		$("#txtEntryCollege_Name").val("");
		$("#txtEntryCollege_Kana").val("");
		// 結果を表示
		$("#strUpdResult").text(data["result"]);		
	})
	// 通信失敗
	.fail(function(jqXHR, textStatus, errorThrown) {
		window.alert("失敗");
		console.log("ajax通信に失敗しました");
		console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
		console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
		console.log("errorThrown    : " + errorThrown.message); // 例外情報
		return;
	})
	// 事後処理
	.always(function() {

	}); 
	}catch(e){
		console.log(e.message);
	}   
}

/**
 * 選手マスタ検索
 */
function searchM_PLAYERSWithAjax(idx){
	// 大学マスタ取得
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	});
	try{
	return $.ajax({
		type        : "get",
	    url         : "/update/ajax/searchM_PLAYERS",
		dataType    : "text",
		async       : "false",
		data        : {
			rowPlayerName : $("#rowPlayerName" + idx).val(),
			rowCollegeCode : $("#rowCollegeCode" + idx).val(),
			ajaxFlg : "test"
		}	
		// 登録前の値を確認する場合
		// ,
		// beforeSend: function ( jqXHR, settings ) {
		// 	alert( settings.type ); 
		// 	alert($("#rowPlayerName" + idx).val() + $("#rowCollegeCode" + idx).val());
		// }			
	});
	}catch(e){
		console.log(e.message);
	}   
}

/**
 * 選手マスタ存在確認ラッパー関数
 * @param {リストのインデックス} idx 
 */
function wpSearchM_PLAYERSWithAjax(idx){
	var testes;
	var akan = searchM_PLAYERSWithAjax(idx).done(function(data, testes) {
		// 選手が存在したかどうかを返す
		window.alert("done"+data);
		testes = data;
	})
	// 通信失敗
	.fail(function(jqXHR, textStatus, errorThrown) {
		window.alert("失敗");
		console.log("ajax通信に失敗しました");
		console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
		console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
		console.log("errorThrown    : " + errorThrown.message); // 例外情報
		return;
	})	
	// 事後処理
	.always(function() {

	}); 
	return akan;
}
