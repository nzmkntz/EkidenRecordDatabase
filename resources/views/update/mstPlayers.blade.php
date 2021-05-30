@extends('base')

@section('title', '箱根駅伝データベース／選手マスタ登録')
@include('head')

@section('body')
    <h1>箱根駅伝データベース／選手マスタ登録</h1>
    <div id="entryForm">
    <form name="mstPlayersEntryForm" id="mstPlayersEntryForm" method="post">
    @csrf
        <b>選手マスタ登録</b><br>
        <span name="strSelectedInfo" id="strSelectedInfo">
        @isset($strUpdResult)
            {!! $strUpdResult !!}
        @endisset 
        </span><br>   
        <input type="hidden" name="hidEntryPlayer_Code" id="hidEntryPlayer_Code" value="">
        選手名<input type="text" name="txtEntryPlayer_Name" id="txtEntryPlayer_Name">
        選手名カナ<input type="text" name="txtEntryPlayer_Kana" id="txtEntryPlayer_Kana">
        <br>
        大学<select name="cmbEntryCollege" id="cmbEntryCollege">
        @isset($mstCollegesList)
            @foreach($mstCollegesList as $row)
                <option name="optRCCC{!! $row->COLLEGE_CODE !!}" value="{!! $row->COLLEGE_CODE !!}">{!! $row->COLLEGE_NAME !!}</option>
            @endforeach
        @endisset 
        </select>
        入学年{!! $cmbYear !!}
        <br>
        出身高校<input type="text" name="txtEntryHighschool" id="txtEntryHighschool">
        出身都道府県{!! $cmbPref !!}
        出身市町村<input type="text" name="txtEntryCity" id="txtEntryCity">
        <br>
        <input type="button" name="entry" value="登録" onclick="fcChkPlayerData()">
        <input type="button" name="clear" value="クリア" onclick="mstPlayerEntryclear('mstPlayersEntryForm')">
    </form>
    </div>
    <hr>
    <div id="list">
    <form action="/update/searchM_PLAYERS" name="mstPlayersList" method="post">
    @csrf
        選手マスタ一覧
        <Br>
        選手名<input type="text" name="txtPlayer_Name">
        選手名カナ<input type="text" name="txtPlayer_Kana">
        <br>
        大学<select name="cmbCollege" id="cmbCollege">
        @isset($mstCollegesList)
            @foreach($mstCollegesList as $row)
                @if($loop->first)
                    {{-- 空欄の設定 --}}
                    <option name="optRCCCBlank" value=""></option>
                @endif()
                <option name="optRCCC{!! $row->COLLEGE_CODE !!}" value="{!! $row->COLLEGE_CODE !!}">{!! $row->COLLEGE_NAME !!}</option>
            @endforeach
        @endisset 
        </select>        
        <input type="submit" name="submit" value="検索">
        <p>
        @isset($mstPlayersList)
        @if($mstPlayersList->count() > 0)
            {{ $mstPlayersList->lastPage() }}ページ中{{ $mstPlayersList->currentPage() }}ページ目を表示<br>
        @endif
        {{-- 現在の検索条件 --}}
        @isset($currentConditionOfCollegeCode)
            {{-- 大学 --}}
            <input type="hidden" name="currentConditionOfCollegeCode" id="currentConditionOfCollegeCode" value="{!! $currentConditionOfCollegeCode !!}">
        @endisset
        @isset($currentConditionOfPlayerName)
            {{-- 選手名 --}}
            <input type="hidden" name="currentConditionOfPlayerName" id="currentConditionOfPlayerName" value="{!! $currentConditionOfPlayerName !!}">
        @endisset
        @isset($currentConditionOfPlayerKana)
            {{-- 選手名カナ --}} 
            <input type="hidden" name="currentConditionOfPlayerKana" id="currentConditionOfPlayerKana" value="{!! $currentConditionOfPlayerKana !!}">
        @endisset   
        <table id="recYearList">
            <th id="rowHSel" class="wd45">選択</th>
            <th id="rowHPlayerCode">選手コード</th>
            <th id="rowHPlayerName" class="wd180">選手名</th>
            <th id="rowHPlayerKana">選手名カナ</th>
            <th id="rowHCollege" class="wd180">所属大学</th>
            <th id="rowHAdmissionYear">入学年</th>             
            <th id="rowHHighschool">出身高校</th>
            <th id="rowHBirthplace">出身地</th> 
            @foreach($mstPlayersList as $row)
            <tr>
                <td class="wd45"><input type="radio" id="rowSel{!! $loop->iteration !!}" name="rowGrpSel" value="{!! $row->PLAYER_CODE !!}" onchange="fcCngPlayerRadio({!! $loop->iteration !!});"></td>
                <td id="rowPlayerCode{!! $loop->iteration !!}">{!! $row->PLAYER_CODE !!}</td>
                <td id="rowPlayerName{!! $loop->iteration !!}" class="wd180">{!! $row->PLAYER_NAME !!}</td>
                <td id="rowPlayerKana{!! $loop->iteration !!}">{!! $row->PLAYER_KANA !!}</td>
                <td id="rowCollege{!! $loop->iteration !!}" class="wd180">{!! $row->M_COLLEGES->COLLEGE_NAME !!}</td>
                <td id="rowAdmissionYear{!! $loop->iteration !!}">{!! $row->ADMISSION_YEAR !!}</td>
                <td id="rowHighschool{!! $loop->iteration !!}">{!! $row->HIGHSCHOOL !!}</td>
                <td id="rowBirthplace{!! $loop->iteration !!}">
                @if(!empty($row->prefectures->PREFNAME))
                    {!! $row->prefectures->PREFNAME !!}
                    @if(!empty($row->CITY))
                        ・{!! $row->CITY !!}
                    @endif
                @elseif(!empty($row->CITY))
                    {!! $row->CITY !!}
                @endif
                </td>
                {{-- 表示しないが保持する項目 --}}
                <input type="hidden" name="hidRowCollegeCode{!! $loop->iteration !!}" id="hidRowCollegeCode{!! $loop->iteration !!}" value="{!! $row->COLLEGE_CODE !!}">
                <input type="hidden" name="hidRowPrefectureCode{!! $loop->iteration !!}" id="hidRowPrefectureCode{!! $loop->iteration !!}" value="{!! $row->PREFECTURE_CODE !!}">
                <input type="hidden" name="hidRowAdmissionYear{!! $loop->iteration !!}" id="hidRowAdmissionYear{!! $loop->iteration !!}" value="{!! $row->ADMISSION_YEAR !!}">
                <input type="hidden" name="hidRowCity{!! $loop->iteration !!}" id="hidRowCity{!! $loop->iteration !!}" value="{!! $row->CITY !!}">
            </tr>
            @endforeach 
        </table>   
        {{ $mstPlayersList->appends(Request::only('cmbCollege'))->links() }}        
        @endisset        
        </p>
    </form>
    </div>
    <p><a href="\update\main">登録メインへ</a></p>
    <p><a href="\">トップへ</a></p>
@endsection

@include('js')