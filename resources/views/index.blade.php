<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('messages.title')</title>
</head>
<body>
    <div class="contentsHeader">
    <h1>@lang('messages.mainTitle')</h1>
    </div>

    <!-- ロケール設定 -->
    <?php 
        $selectedEn = "";
        $selectedJp = "";
        // 現在のロケールを取得
        $currentLocale = App::getLocale();
        // ロケールを判定
        if($currentLocale == "en"){
            // ロケールが英語の場合、コンボボックスのEnglishを選択
            $selectedEn = "selected";
        }
        else if($currentLocale == "jp"){
            // ロケールが日本語の場合、コンボボックスの日本語を選択
            $selectedJp = "selected";
        } 
    ?>
    <div class="setLocale">
    <form action="/" name="frmSetLocale" method="post">
    @csrf
        <p>
        <?php echo $currentLocale ?>
        <!-- ロケールのコンボボックス -->
        <select name="setLocale">
            <option id="localeEN" value="en" <?php echo $selectedEn ?>>English</option>
            <option id="localeJP" value="jp" <?php echo $selectedJp ?>>日本語</option>
        </select>
        <input type="submit" value="@lang('messages.mainBtnChangeLanguage')">
        </p>
    </form>
    </div>

    <p><a href="\search\main">@lang('messages.mainOfSearch')</a></p>
    <p><a href="\update\main">@lang('messages.mainOfUpdate')</a></p>
    <p><a href="\maintenance\main">@lang('messages.mainOfMaintenance')</a></p>

</body>
</html>