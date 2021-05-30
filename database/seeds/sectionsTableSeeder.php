<?php

use Illuminate\Database\Seeder;
use App\section;

class sectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // sectionsテーブルの初期化
        DB::table('sections')->truncate();

        $sections = [
            ['SECTION_CODE' => '01',
             'SECTION_NAME' => '1区',
             'EFFECTIVE_YEAR' => '1900',
             'START_RS' => '大手町',
             'END_RS' => '鶴見中継所',
             'SECTION_DISTANCE' => '20.0'                      
            ],
            ['SECTION_CODE' => '02',
             'SECTION_NAME' => '2区',
             'EFFECTIVE_YEAR' => '1900',
             'START_RS' => '鶴見中継所',
             'END_RS' => '戸塚中継所',
             'SECTION_DISTANCE' => '20.0'                      
            ],
            ['SECTION_CODE' => '03',
             'SECTION_NAME' => '3区',
             'EFFECTIVE_YEAR' => '1900',
             'START_RS' => '戸塚中継所',
             'END_RS' => '平塚中継所',
             'SECTION_DISTANCE' => '20.0'                      
            ],    
            ['SECTION_CODE' => '04',
             'SECTION_NAME' => '4区',
             'EFFECTIVE_YEAR' => '1900',
             'START_RS' => '平塚中継所',
             'END_RS' => '小田原中継所',
             'SECTION_DISTANCE' => '20.0'                      
            ],  
            ['SECTION_CODE' => '05',
             'SECTION_NAME' => '5区',
             'EFFECTIVE_YEAR' => '1900',
             'START_RS' => '小田原中継所',
             'END_RS' => '芦ノ湖',
             'SECTION_DISTANCE' => '20.0'                      
            ],
            ['SECTION_CODE' => '06',
             'SECTION_NAME' => '6区',
             'EFFECTIVE_YEAR' => '1900',
             'START_RS' => '芦ノ湖',
             'END_RS' => '小田原中継所',
             'SECTION_DISTANCE' => '20.0'                      
            ], 
            ['SECTION_CODE' => '07',
             'SECTION_NAME' => '7区',
             'EFFECTIVE_YEAR' => '1900',
             'START_RS' => '小田原中継所',
             'END_RS' => '平塚中継所',
             'SECTION_DISTANCE' => '20.0',                      
            ],                      
            ['SECTION_CODE' => '08',
             'SECTION_NAME' => '8区',
             'EFFECTIVE_YEAR' => '1900',
             'START_RS' => '平塚中継所',
             'END_RS' => '戸塚中継所',
             'SECTION_DISTANCE' => '20.0'                      
            ],
            ['SECTION_CODE' => '09',
             'SECTION_NAME' => '9区',
             'EFFECTIVE_YEAR' => '1900',
             'START_RS' => '戸塚中継所',
             'END_RS' => '鶴見中継所',
             'SECTION_DISTANCE' => '20.0'                      
            ],     
            ['SECTION_CODE' => '10',
             'SECTION_NAME' => '10区',
             'EFFECTIVE_YEAR' => '1900',
             'START_RS' => '鶴見中継所',
             'END_RS' => '大手町',
             'SECTION_DISTANCE' => '20.0'                      
            ],                      
           ];

        // 登録
        foreach($sections as $section) {
            section::create($section);
        }  
    }
}
