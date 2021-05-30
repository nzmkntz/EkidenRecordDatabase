<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;    // 追加した参照

////////////////////////
//
// 箱根DB：メンテナンスクラス
//
////////////////////////
class MaintenanceController extends Controller
{
    /**
     * 認証
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // メンテナンス：メイン
    public function maintenanceMain(){

        return View::make("/maintenance/maintenanceMain");

    }
}
