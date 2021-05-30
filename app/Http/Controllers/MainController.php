<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;    

class MainController extends Controller
{
    // ロケール設定
    public function setLocale(Request $req){
        // ロケール設定用の値が含まれるか確認   
        if($req->filled("setLocale") == true){   
            // ロケールを設定
            App::setLocale($req->get("setLocale"));
        }

        // メインページに戻る
        return View::make('index');
    }
}
