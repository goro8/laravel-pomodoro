<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PomodoroController; 
// ↑ PomodoroController クラスを使う宣言
//   Controller（コントローラ）＝画面を返す処理をまとめたクラス

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| ここでは「どの URL にアクセスされたら、どの処理を呼ぶか」を定義します。
| 例）'/' に来たら、PomodoroController の index() を実行する、など。
|
*/

Route::get('/', [PomodoroController::class, 'index'])
    ->name('pomodoro.index');
// ↑ Route::get('/', ...) : ブラウザで '/' に GET アクセスされたときのルート設定
//   [PomodoroController::class, 'index'] : 
//      PomodoroController の index() メソッドを呼ぶ、という指定
//   ->name('pomodoro.index') : 
//      このルートに 'pomodoro.index' という名前を付けておく（後でリンク生成などに使える）
