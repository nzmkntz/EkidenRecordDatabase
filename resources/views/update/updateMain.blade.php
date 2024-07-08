@extends('base')

@section('title', '箱根駅伝データベース／登録メイン')
@include('head')

@section('body')
    <h1>@lang('messages.searchPlayerTitle')</h1>

    <div><a href="\update\recYear">記録登録（年別）</a></div><br>
    <div><a href="\update\recPlayer">記録登録（選手別）</a></div><br>
    <div><a href="\update\mstColleges">大学マスタ登録</a></div><br>
    <div><a href="\update\mstPlayers">選手マスタ登録</a></div><br>

    <p><a href="\">トップへ</a></p>
@endsection

@include('js')