@extends('base')

@section('title', '箱根駅伝データベース／大学マスタ登録')
@include('head')

@section('body')
    <h1>箱根駅伝データベース／大学マスタ登録</h1>
    <div id="entryForm">
    <form name="mstCollegesEntryForm" id="mstCollegesEntryForm" method="post">
    @csrf
        <b>大学マスタ登録</b><br>
        <span name="strSelectedInfo" id="strSelectedInfo">
        @isset($strUpdResult)
            {!! $strUpdResult !!}
        @endisset 
        </span><br>       
        <input type="hidden" name="hidEntryCollege_Code" id="hidEntryCollege_Code" value="">
        大学名<input type="text" name="txtEntryCollege_Name" id="txtEntryCollege_Name">
        大学名カナ<input type="text" name="txtEntryCollege_Kana" id="txtEntryCollege_Kana"><br>
        カラー<br>
        オープン参加<input type="checkbox" id="chkOpen" name="chkOpen" value="1"><br>   
        <input type="button" name="entry" value="登録" onclick="fcChkEntryData()">
        <input type="button" name="clear" value="クリア" onclick="mstCollegeEntryclear()">
    </form>
    </div>
    <hr>
    <div id="list">
    <form action="/update/searchM_COLLEGES" name="mstCollegesList" method="post">
    @csrf
        <b>大学マスタ一覧</b>
        <br>
        大学名<input type="text" id="txtCollege_Name" name="txtCollege_Name">
        大学名カナ<input type="text" id="txtCollege_Kana" name="txtCollege_Kana"><br>
        <input type="submit" name="submit" value="検索">
        <p>
        @isset($mstCollegesList)
        @if($mstCollegesList->count() > 0)
            {{ $mstCollegesList->lastPage() }}ページ中{{ $mstCollegesList->currentPage() }}ページ目を表示<br>
        @endif
        <table id="recYearList">
            <th id="rowHSel" class="wd45">選択</th>
            <th id="rowHCollegeCode">大学コード</th>
            <th id="rowHCollegeName" class="wd180">大学名</th>
            <th id="rowHCollegeKana">大学名カナ</th>
            <th id="rowHColor">カラー</th>
            <th id="rowHOpen">オープン参加</th>
            @foreach($mstCollegesList as $row)
            <tr>
                {{-- オープン参加フラグの値設定 --}}
                @if($row->OPEN_ENTRY_FLAG === 1)
                    <?php $chkOpen = "オープン"?>
                @else
                    <?php $chkOpen = ""?>
                @endif
                <td class="wd45"><input type="radio" id="rowSel{!! $loop->iteration !!}" name="rowGrpSel" value="{!! $row->COLLEGE_CODE !!}" onchange="fcCngRadio({!! $loop->iteration !!});"></td>
                <td id="rowCollegeCode{!! $loop->iteration !!}">{!! $row->COLLEGE_CODE !!}</td>
                <td id="rowCollegeName{!! $loop->iteration !!}" class="wd180">{!! $row->COLLEGE_NAME !!}</td>
                <td id="rowCollegeKana{!! $loop->iteration !!}">{!! $row->COLLEGE_KANA !!}</td>
                <td>-</td>
                <td id="rowOpen{!! $loop->iteration !!}">{!! $chkOpen !!}</td>
            </tr>
            @endforeach 
        </table>   
        {{ $mstCollegesList->links() }}        
        @endisset
        </p>
    </form>
    </div>
    <p><a href="\update\main">登録メインへ</a></p>
    <p><a href="\">トップへ</a></p>
@endsection

@include('js')