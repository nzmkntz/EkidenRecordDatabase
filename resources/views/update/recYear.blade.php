@extends('base')

@section('title', '箱根駅伝データベース／記録登録（年別）')
@include('head')

@section('body')
    <h1>箱根駅伝データベース／記録登録（年別）</h1>
    <form action="\update\recYear\search" name="searchform" method="post">   
    @csrf
    登録する年を選択してください<br>
    {!! $cmbYear !!}
    <br>
    <input type="submit" name="submit" value="検索">
    </form>
    <!-- selYearがセットされている場合 -->
    @isset($selYear)
        <form action="\update\recYear\update" name="updRecYearForm" method="post" onsubmit="return fcChkRecYear();">       
        @csrf
        <hr>            
        @isset($updResult)
            {!! $updResult !!}<br>
        @endisset
        {!! $selYear !!}年のデータを編集 登録チーム数：{!! $rowCnt !!}
        <input type="hidden" id="hdnSelYear" name="hdnSelYear" value="{!! $selYear !!}">
        <input type="hidden" id="hdnRowCnt" name="hdnRowCnt" value="{!! $rowCnt !!}">
        <div id="lbltest"></div>
        <br>
        <table id="recYearList">
            <th id="rowHDel" class="wd45">削除</th>            
            <th id="rowHCollegeCode" class="wd180">大学名</th>
            <th id="rowHTimeRecord">タイム</th>
            <th id="rowHOpen">オープン参加</th>
            <th id="rowHDefault">棄権</th>
            <th id="rowHSeed">シード</th>
            <th id="rowHMemo">メモ</th>
        @isset($results)
            {!! $results !!}
        @endisset
        </table>
        <input type="button" name="btnNewRow" id="btnNewRow" value="新規行追加" onclick="fcMakeInputRowCollege()">
        <a href="javascript:void(0)" onclick="makeModal();return false;" id="addMColleges">大学マスタ登録</a><br>
        <input type="submit" name="sbmEntry" id="sbmEntry" value="登録">
        </form>
    @endisset
    <p><a href="\update\main">登録メインへ</a></p>
    <p><a href="\">トップへ</a></p>

    <div class="modal">
        <div class="modalBase">
        </div>
        <div class="modalContent">
            <form name="mstCollegesEntryForm" id="mstCollegesEntryForm" method="post">
                <span id="strUpdResult"></span>
                <br>
                大学マスタ登録
                <br>       
                <input type="hidden" name="hidEntryCollege_Code" id="hidEntryCollege_Code" value="">
                大学名<input type="text" name="txtEntryCollege_Name" id="txtEntryCollege_Name"><br>
                大学名カナ<input type="text" name="txtEntryCollege_Kana" id="txtEntryCollege_Kana">
                <br>
                <input type="button" name="entry" value="登録" onclick="fcChkEntryData('modal')">
                <input type="button" name="clear" value="クリア" onclick="mstCollegeEntryclear()">
                <br>
            </form>
            <a class="" href="" onclick="closeModal();return false;">閉じる</a>
        </div><!--modal__inner-->
    </div><!--modal-->    
@endsection


@include('js')