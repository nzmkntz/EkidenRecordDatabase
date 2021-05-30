<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 区間マスタ
        $this->call(sectionsTableSeeder::class);
        // 都道府県マスタ
        $this->call(prefecturesTableSeeder::class);        
    }
}
