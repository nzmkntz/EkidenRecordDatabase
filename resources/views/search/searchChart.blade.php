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
        <input type="submit" name="submit" value="検索">
        </P>
    </form>   
    <div class="canvas-container">
        <canvas id="myChart" width="400" height="400"></canvas>
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