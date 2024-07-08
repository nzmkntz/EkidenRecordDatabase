@extends('base')

@section('title', '箱根駅伝データベース／検索メイン')
@include('head')

@section('body')
    <div class="contentsHeader">
    <h1>@lang('messages.searchSectionTitle')</h1>
    </div>
    <!-- chart.js -->
    <a href="/search/chart">@lang('messages.searchSectChartLink')</a>
    <!-- form -->    
    <form action="\search\exec" name="searchform" method="post">
    @csrf
    @lang('messages.searchSectPleaseSelYear')<br>
    {!! $cmbYear !!}
    <br>
    <input type="checkbox" name="chkTypeSect" id="chkTypeSect" value="chkTypeSect" onclick="fcCheckDataType('chkTypeSect');">区間から選択
    {!! $cmbSect !!}
    <br>
    <input type="checkbox" name="chkTypeCollege" id="chkTypeCollege" value="chkTypeCollege" onclick="fcCheckDataType('chkTypeCollege');">出場大学から選択
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
    @isset($results)
        <hr>
        @if($selType != "")
        {{-- selYearとselTypeがセットされている場合 --}}
            @isset($selYear)
                {!! $selYear !!}年のデータを表示中<br>
            @endisset        
            <table>
            @if($selType == "chkTypeCollege")
                <th>section</th><th>name</th><th>time</th><th>open Entry</th>
            @elseif($selType == "chkTypeSect")            
                <th>rank</th><th>name</th><th>time</th><th>open Entry</th>
            @endif
            @foreach($results as $row)
                {{-- シード色設定 --}}
                <?php $seed = "";?>
                @if($row->SEED_ENTRY_FLAG === 1)   
                    <?php $seed = " class=\"seed\"";?>
                @endif
                {{-- オープン参加表示 --}}
                <?php $openEnt = "";?>
                @if($row->OPEN_ENTRY_FLAG === 1)   
                    <?php $openEnt = "オープン";?>
                @endif
                <tr>
                @if($selType == "chkTypeCollege")
                {{-- 大学指定の場合、1列目:区間名、2列目:選手名 --}}
                    <td{!! $seed !!}>{{ $row->sections->SECTION_NAME }}</td>
                    <td><a href="\search\player\{{ $row->M_PLAYERS->PLAYER_CODE }}">{{ $row->M_PLAYERS->PLAYER_NAME }}</a></td>                    
                @elseif($selType == "chkTypeSect")
                    {{-- 区間指定の場合、1列目:番号、2列目:大学名 --}}
                    <td>{{ $loop->iteration }}</td>
                    <td{!! $seed !!}>{{ $row->M_COLLEGES->COLLEGE_NAME }}</td>
                @endif   
                <td>{{ $row->TIME_RECORD }}</td>
                <td>{!! $openEnt !!}</td>
                </tr>
            @endforeach
            </table>
        @elseif($selType == "")        
            {{-- selYearのみがセットされている場合 --}}
            @isset($selYear)
                {!! $selYear !!}年のデータを表示中<br>
            @endisset        
            <table>
            <th>rank</th><th>name</th><th>time</th><th>open Entry</th>
            @foreach($results as $row)
                {{-- シード色設定 --}}
                <?php $seed = "";?>
                @if($row->SEED_ENTRY_FLAG === 1)   
                    <?php $seed = " class=\"seed\"";?>
                @endif
                {{-- オープン参加表示 --}}
                <?php $openEnt = "";?>
                @if($row->OPEN_ENTRY_FLAG === 1)   
                    <?php $openEnt = "オープン";?>
                @endif
                <tr>
                <td>{{ $loop->iteration }}</td>
                <td{!! $seed !!}>{{ $row->M_COLLEGES->COLLEGE_NAME }}</td>
                <td>{{ $row->TIME_RECORD }}</td>
                <td>{!! $openEnt !!}</td>
                </tr>
            @endforeach
            </table>
        @endif
    @endisset
    <p><a href="\">トップへ</a></p>
@endsection

@include('js')