@section('update.partEntryCollege')   
        <input type="hidden" name="hidEntryCollege_Code" id="hidEntryCollege_Code" value="">
        大学名<input type="text" name="txtEntryCollege_Name" id="txtEntryCollege_Name">
        大学名カナ<input type="text" name="txtEntryCollege_Kana" id="txtEntryCollege_Kana">
        <br>
        <input type="button" name="entry" value="登録" onclick="fcChkEntryData()">
        <input type="button" name="clear" value="クリア" onclick="mstCollegeEntryclear()">
@endsection