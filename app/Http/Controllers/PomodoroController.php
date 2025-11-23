<?php

namespace App\Http\Controllers;

// Controller クラスを継承して、自分用のコントローラを作る
class PomodoroController extends Controller
{
    /**
     * ポモドーロタイマーのメイン画面を表示するアクション
     *
     * index()：
     *   「/」にアクセスされたときに呼ばれるメソッド。
     *   → resources/views/pomodoro.blade.php を探して表示しようとする。
     */
    public function index()
    {
        // view('pomodoro') の意味：
        //   Blade テンプレート「pomodoro.blade.php」を探して表示する。
        //   まだファイルを作っていないので、このコミット時点では
        //   「View [pomodoro] not found.」エラーになる → 想定通り。
        return view('pomodoro');
    }
}
