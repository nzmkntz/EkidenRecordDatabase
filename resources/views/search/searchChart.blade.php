@extends('baseChart')

@section('title', '箱根駅伝データベース／検索メイン')
@include('headChart')

@section('body')
    <div class="contentsHeader">
    <h1>箱根駅伝データベース／チャート</h1>
    </div>
    <p><a href="/search/main">検索メインへ</a></p> 
    <form action="/search/chart" name="frmChart" method="get">
        <p>
        {!! $cmbYear !!}
        <select name="cmbChartType" id="cmbChartType" >
            <option name="optSection" value="0">区間タイム</option>
            <option name="optAccumulate" value="1">累積タイム</option>
        </select>
        <input type="submit" name="submit" value="検索">
        </P>
        {!! $strChartYear !!}年の{!! $strMyChart !!}を表示
    </form>   
    <div class="canvas-container">
        <canvas id="myChart" width="400" height="500"></canvas>
    </div>
    <p><a href="\">トップへ</a></p>
@endsection

@include('js')

<script>
    window.onload = function(){
            drawChart({!! $myChart !!});
    };
    window.onresize = function(){
            drawChart({!! $myChart !!});
    };    
</script>