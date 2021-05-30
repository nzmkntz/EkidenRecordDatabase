<?php

use Illuminate\Database\Seeder;
use App\prefecture;

class prefecturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // prefecturesテーブルの初期化
        DB::table('prefectures')->truncate();

        $prefectures = [ 
            ['PREFECTURE_CODE' => '01', 'PREFNAME' => '北海道', 'PREFKANA' => 'ほっかいどう'],
            ['PREFECTURE_CODE' => '02', 'PREFNAME' => '青森県', 'PREFKANA' => 'あおもりけん'],
            ['PREFECTURE_CODE' => '03', 'PREFNAME' => '岩手県', 'PREFKANA' => 'いわてけん'],
            ['PREFECTURE_CODE' => '04', 'PREFNAME' => '宮城県', 'PREFKANA' => 'みやぎけん'],
            ['PREFECTURE_CODE' => '05', 'PREFNAME' => '秋田県', 'PREFKANA' => 'あきたけん'],
            ['PREFECTURE_CODE' => '06', 'PREFNAME' => '山形県', 'PREFKANA' => 'やまがたけん'],
            ['PREFECTURE_CODE' => '07', 'PREFNAME' => '福島県', 'PREFKANA' => 'ふくしまけん'],
            ['PREFECTURE_CODE' => '08', 'PREFNAME' => '茨城県', 'PREFKANA' => 'いばらきけん'],
            ['PREFECTURE_CODE' => '09', 'PREFNAME' => '栃木県', 'PREFKANA' => 'とちぎけん'],
            ['PREFECTURE_CODE' => '10', 'PREFNAME' => '群馬県', 'PREFKANA' => 'ぐんまけん'],
            ['PREFECTURE_CODE' => '11', 'PREFNAME' => '埼玉県', 'PREFKANA' => 'さいたまけん'],
            ['PREFECTURE_CODE' => '12', 'PREFNAME' => '千葉県', 'PREFKANA' => 'ちばけん'],
            ['PREFECTURE_CODE' => '13', 'PREFNAME' => '東京都', 'PREFKANA' => 'とうきょうと'],
            ['PREFECTURE_CODE' => '14', 'PREFNAME' => '神奈川県', 'PREFKANA' => 'かながわけん'],
            ['PREFECTURE_CODE' => '15', 'PREFNAME' => '新潟県', 'PREFKANA' => 'にいがたけん'],
            ['PREFECTURE_CODE' => '16', 'PREFNAME' => '富山県', 'PREFKANA' => 'とやまけん'],
            ['PREFECTURE_CODE' => '17', 'PREFNAME' => '石川県', 'PREFKANA' => 'いしかわけん'],
            ['PREFECTURE_CODE' => '18', 'PREFNAME' => '福井県', 'PREFKANA' => 'ふくいけん'],
            ['PREFECTURE_CODE' => '19', 'PREFNAME' => '山梨県', 'PREFKANA' => 'やまなしけん'],
            ['PREFECTURE_CODE' => '20', 'PREFNAME' => '長野県', 'PREFKANA' => 'ながのけん'],
            ['PREFECTURE_CODE' => '21', 'PREFNAME' => '岐阜県', 'PREFKANA' => 'ぎふけん'],
            ['PREFECTURE_CODE' => '22', 'PREFNAME' => '静岡県', 'PREFKANA' => 'しずおかけん'],
            ['PREFECTURE_CODE' => '23', 'PREFNAME' => '愛知県', 'PREFKANA' => 'あいちけん'],
            ['PREFECTURE_CODE' => '24', 'PREFNAME' => '三重県', 'PREFKANA' => 'みえけん'],
            ['PREFECTURE_CODE' => '25', 'PREFNAME' => '滋賀県', 'PREFKANA' => 'しがけん'],
            ['PREFECTURE_CODE' => '26', 'PREFNAME' => '京都府', 'PREFKANA' => 'きょうとふ'],
            ['PREFECTURE_CODE' => '27', 'PREFNAME' => '大阪府', 'PREFKANA' => 'おおさかふ'],
            ['PREFECTURE_CODE' => '28', 'PREFNAME' => '兵庫県', 'PREFKANA' => 'ひょうごけん'],
            ['PREFECTURE_CODE' => '29', 'PREFNAME' => '奈良県', 'PREFKANA' => 'ならけん'],
            ['PREFECTURE_CODE' => '30', 'PREFNAME' => '和歌山県', 'PREFKANA' => 'わかやまけん'],
            ['PREFECTURE_CODE' => '31', 'PREFNAME' => '鳥取県', 'PREFKANA' => 'とっとりけん'],
            ['PREFECTURE_CODE' => '32', 'PREFNAME' => '島根県', 'PREFKANA' => 'しまねけん'],
            ['PREFECTURE_CODE' => '33', 'PREFNAME' => '岡山県', 'PREFKANA' => 'おかやまけん'],
            ['PREFECTURE_CODE' => '34', 'PREFNAME' => '広島県', 'PREFKANA' => 'ひろしまけん'],
            ['PREFECTURE_CODE' => '35', 'PREFNAME' => '山口県', 'PREFKANA' => 'やまぐちけん'],
            ['PREFECTURE_CODE' => '36', 'PREFNAME' => '徳島県', 'PREFKANA' => 'とくしまけん'],
            ['PREFECTURE_CODE' => '37', 'PREFNAME' => '香川県', 'PREFKANA' => 'かがわけん'],
            ['PREFECTURE_CODE' => '38', 'PREFNAME' => '愛媛県', 'PREFKANA' => 'えひめけん'],
            ['PREFECTURE_CODE' => '39', 'PREFNAME' => '高知県', 'PREFKANA' => 'こうちけん'],
            ['PREFECTURE_CODE' => '40', 'PREFNAME' => '福岡県', 'PREFKANA' => 'ふくおかけん'],
            ['PREFECTURE_CODE' => '41', 'PREFNAME' => '佐賀県', 'PREFKANA' => 'さがけん'],
            ['PREFECTURE_CODE' => '42', 'PREFNAME' => '長崎県', 'PREFKANA' => 'ながさきけん'],
            ['PREFECTURE_CODE' => '43', 'PREFNAME' => '熊本県', 'PREFKANA' => 'くまもとけん'],
            ['PREFECTURE_CODE' => '44', 'PREFNAME' => '大分県', 'PREFKANA' => 'おおいたけん'],
            ['PREFECTURE_CODE' => '45', 'PREFNAME' => '宮崎県', 'PREFKANA' => 'みやざきけん'],
            ['PREFECTURE_CODE' => '46', 'PREFNAME' => '鹿児島県', 'PREFKANA' => 'かごしまけん'],
            ['PREFECTURE_CODE' => '47', 'PREFNAME' => '沖縄県', 'PREFKANA' => 'おきなわけん']
        ]; 
        
        // 登録
        foreach($prefectures as $pref) {
            prefecture::create($pref);
        }
    }
}