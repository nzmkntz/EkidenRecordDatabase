@extends('base')

@section('title', '箱根駅伝データベース／記録登録（選手別）')
@include('head')

@section('body')
    <h1>箱根駅伝データベース／記録登録（選手別）</h1>
    <form action="\update\recPlayer\search" name="searchform" method="post" onsubmit="fcSelRecPlayer();">   
    @csrf
    登録する年を選択してください<br>    
    {!! $cmbYear !!}
    <br>
    <input type="radio" name="rdoTypeSectCollege" id="rdoTypeSect" value="rdoTypeSect" onclick="fcCngDataType('rdoTypeSect');" checked>区間から選択
    {!! $cmbSect !!}
    <br>
    <input type="radio" name="rdoTypeSectCollege" id="rdoTypeCollege" value="rdoTypeCollege" onclick="fcCngDataType('rdoTypeCollege');">出場大学から選択
    <select name="cmbCollege" id="cmbCollege" disabled>
    @isset($mstCollegesList)
        @foreach($mstCollegesList as $row)
            <option name="optRCCC{!! $row->COLLEGE_CODE !!}" value="{!! $row->COLLEGE_CODE !!}">{!! $row->COLLEGE_NAME !!}</option>
        @endforeach
    @endisset 
    </select>
    <input type="hidden" id="hdnSelTypeStr" name="hdnSelTypeStr" value="">
    <br>
    <input type="submit" name="submit" value="検索">
    </form>
    <!-- selYearがセットされている場合 -->
    @isset($selYear)
        <form action="\update\recPlayer\update" name="updRecPlayerForm" method="post" onsubmit="return fcChkRecPlayer();">       
        @csrf
        <hr>            
        @isset($updResult)
            {!! $updResult !!}<br>
        @endisset
        {!! $selYear !!}年 {!! $selTypeVal !!} のデータを編集
        <input type="hidden" id="hdnSelYear" name="hdnSelYear" value="{!! $selYear !!}">
        <input type="hidden" id="hdnSelType" name="hdnSelType" value="{!! $selType !!}">
        <input type="hidden" id="hdnSelTypeVal" name="hdnSelTypeVal" value="{!! $selTypeVal !!}">  
        <input type="hidden" id="hdnSelTypeCode" name="hdnSelTypeCode" value="{!! $selTypeCode !!}">                   
        <input type="hidden" id="hdnRowCnt" name="hdnRowCnt" value="{!! $rowCnt !!}">
        <div id="lbltest"></div>
        <br>
        <table id="recPlayerList">
            @if($selType == "rdoTypeSect")
                {{-- 区間で検索したときは1列目に順位を表示 --}}   
                <th id="rowHOrder" class="wd45">順位</th>     
                <th id="rowHCollegeCode" class="wd180">大学名</th>                                  
            @elseif($selType == "rdoTypeCollege")
                {{-- 大学で検索したときは1列目に区間名を表示 --}}                
                <th id="rowHSectionName" class="wd45">区間</th>    
            @endif                    
            <th id="rowHPlayerName">選手名</th>
            <th id="rowHTimeRecord">タイム</th>
            <th id="rowHOpen">参考記録</th>
            <th id="rowHDefault">棄権</th>
            @foreach($results as $row)
            <tr>
                {{-- 棄権フラグの値設定 --}}
                @if($row->DEFAULT_FLAG === 1)
                    <?php $chkDefault = "checked"?>
                @else
                    <?php $chkDefault = ""?>
                @endif  
                {{-- 参考記録フラグの値設定 --}}
                @if($row->UNOFFICIAL_FLAG === 1)
                    <?php $chkUnofficial = "checked"?>
                @else
                    <?php $chkUnofficial = ""?>
                @endif     
        
                @if($selType == "rdoTypeSect")
                    {{-- タイムが入力されていれば順位を設定（いずれ参考・棄権も考慮） --}}                            
                    @if($row->TIME_RECORD != null)
                        <?php $intOrder = $loop->iteration;?>
                    @else
                        <?php $intOrder = "-"?>
                    @endif
                    {{-- 区間で検索したときは1列目に順位を表示 --}}   
                    <td id="rowOrder{!! $loop->iteration !!}" class="wd45">{!! $intOrder !!}</td>                                    
                    <td id="rowCollegeName{!! $loop->iteration !!}" name="rowCollegeName{!! $loop->iteration !!}" class="wd180">{!! $row->COLLEGE_NAME !!}</td>
                @elseif($selType == "rdoTypeCollege")
                    {{-- 大学で検索したときは1列目に区間名を表示 --}}                
                    <td id="rowSectionName{!! $loop->iteration !!}" class="wd45">{!! $row->SECTION_NAME !!}</td>
                @endif
                <td><input type="text" id="rowPlayerName{!! $loop->iteration !!}" name="rowPlayerName{!! $loop->iteration !!}" value="{!! $row->PLAYER_NAME !!}"></td>
                <td><input type="text" id="rowTimeRecord{!! $loop->iteration !!}" name="rowTimeRecord{!! $loop->iteration !!}" value="{!! $row->TIME_RECORD !!}"></td>
                <td><input type="checkbox" id="rowDefault{!! $loop->iteration !!}" name="rowDefault{!! $loop->iteration !!}" value="1" {!! $chkDefault !!}></td>
                <td><input type="checkbox" id="rowUnofficial{!! $loop->iteration !!}" name="rowUnofficial{!! $loop->iteration !!}" value="1" {!! $chkUnofficial !!}></td>
                <input type="hidden" id="rowCollegeCode{!! $loop->iteration !!}" name="rowCollegeCode{!! $loop->iteration !!}" value="{!! $row->COLLEGE_CODE !!}">             
                <input type="hidden" id="rowSectionCode{!! $loop->iteration !!}" name="rowSectionCode{!! $loop->iteration !!}" value="{!! $row->SECTION_CODE !!}">
                <input type="hidden" id="rowPlayerCode{!! $loop->iteration !!}" name="rowPlayerCode{!! $loop->iteration !!}" value="{!! $row->PLAYER_CODE !!}">
            </tr>
            @endforeach   
        </table>
        <br>
        <input type="submit" name="sbmEntry" id="sbmEntry" value="登録">
        </form>
    @endisset    
    <p><a href="\update\main">登録メインへ</a></p>
    <p><a href="\">トップへ</a></p>
@endsection

@include('js')