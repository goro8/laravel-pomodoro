<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>世界一シンプルなポモドーロ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        /* 画面全体の基本スタイル */
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;       /* 縦方向センタリング */
            justify-content: center;   /* 横方向センタリング */
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f4f4f5;       /* うすいグレー背景 */
        }

        /* ポモドーロ全体を包むカード */
        .pomodoro-container {
            background: #ffffff;
            padding: 24px 28px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            max-width: 420px;
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }

        .pomodoro-title {
            margin: 0 0 16px;
            font-size: 20px;
            font-weight: 600;
        }

        /* タイマーの数字 */
        .timer-display {
            font-size: 48px;
            font-weight: 700;
            letter-spacing: 0.1em;
            margin: 12px 0 20px;
        }

        /* ボタン3つの並び */
        .button-group {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .button-group button {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        /* メモ入力欄 */
        .memo-area {
            margin-bottom: 16px;
            text-align: left;
        }

        .memo-area label {
            display: block;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .memo-area input {
            width: 100%;
            padding: 6px 8px;
            border-radius: 6px;
            border: 1px solid #d4d4d8;
            box-sizing: border-box;
            font-size: 14px;
        }

        /* 今日のポモ数表示 */
        .count-area {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="pomodoro-container">
        <h1 class="pomodoro-title">世界一シンプルなポモドーロ</h1>

        <!-- タイマー表示（まだJSは未実装なので、2-4では固定表示のまま） -->
        <div class="timer-display" id="timer-display">
            25:00
        </div>

        <!-- Start / Pause / Reset ボタン -->
        <div class="button-group">
            <button id="start-btn">Start</button>
            <button id="pause-btn">Pause</button>
            <button id="reset-btn">Reset</button>
        </div>

        <!-- 今日の一行メモ -->
        <div class="memo-area">
            <label for="memo-input">今日の一行メモ</label>
            <input
                id="memo-input"
                type="text"
                placeholder="例）午前中はポモ3本やる"
            >
        </div>

        <!-- 今日のポモ数 -->
        <div class="count-area">
            <span>今日のポモ数：</span>
            <span id="pomodoro-count">0</span>
        </div>
    </div>

    <script>
        // ===== ここからポモドーロタイマー用のJavaScript =====

        // 1ポモの時間（分）
        const WORK_MINUTES = 25;
        // 残り時間（秒）を管理する変数
        const INITIAL_SECONDS = WORK_MINUTES * 60;
        let remainingSeconds = INITIAL_SECONDS;

        // setInterval のIDを保存しておく変数（動いているかどうかの判定にも使う）
        let timerId = null;

        // 画面上の要素を取得
        const timerDisplay = document.getElementById('timer-display');
        const startBtn = document.getElementById('start-btn');
        const pauseBtn = document.getElementById('pause-btn');
        const resetBtn = document.getElementById('reset-btn');
        const memoInput = document.getElementById('memo-input');
        const pomodoroCountSpan = document.getElementById('pomodoro-count');

        /**
         * 今日の日付（YYYY-MM-DD 形式）を返す
         * 例：2025-11-23
         */
        function getTodayKey() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // localStorage 用のキー（「日付ごと」にメモとポモ数を分ける）
        const todayKey = getTodayKey();
        const COUNT_KEY = `pomodoro_count_${todayKey}`;
        const MEMO_KEY = `pomodoro_memo_${todayKey}`;

        /**
         * 残り秒数から、画面上の mm:ss 表示を更新する
         */
        function updateDisplay() {
            const minutes = Math.floor(remainingSeconds / 60);
            const seconds = remainingSeconds % 60;
            const mm = String(minutes).padStart(2, '0');
            const ss = String(seconds).padStart(2, '0');
            timerDisplay.textContent = `${mm}:${ss}`;
        }

        /**
         * localStorage から、今日のポモ数とメモを読み込んで画面に反映
         */
        function loadFromStorage() {
            const savedCount = localStorage.getItem(COUNT_KEY);
            if (savedCount !== null) {
                pomodoroCountSpan.textContent = savedCount;
            }

            const savedMemo = localStorage.getItem(MEMO_KEY);
            if (savedMemo !== null) {
                memoInput.value = savedMemo;
            }
        }

        /**
         * 今日のポモ数を保存
         */
        function saveCount(count) {
            localStorage.setItem(COUNT_KEY, String(count));
        }

        /**
         * メモを保存
         */
        function saveMemo(value) {
            localStorage.setItem(MEMO_KEY, value);
        }

        /**
         * タイマーをスタート（すでに動いていれば何もしない）
         */
        function startTimer() {
            // すでに setInterval が動いている場合は二重起動を防ぐ
            if (timerId !== null) {
                return;
            }

            timerId = setInterval(() => {
                remainingSeconds--;

                // 0秒以下にならないようにする
                if (remainingSeconds <= 0) {
                    remainingSeconds = 0;
                    updateDisplay();

                    // タイマー停止
                    clearInterval(timerId);
                    timerId = null;

                    // 1ポモ完了 → 今日のポモ数を +1
                    let currentCount = parseInt(pomodoroCountSpan.textContent, 10) || 0;
                    currentCount++;
                    pomodoroCountSpan.textContent = currentCount;
                    saveCount(currentCount);

                    // 簡易な完了通知
                    alert('1ポモ完了！おつかれさまです 🎉');

                    return;
                }

                // 1秒進むごとに表示を更新
                updateDisplay();
            }, 1000); // 1000ミリ秒ごと（＝1秒ごと）
        }

        /**
         * タイマーを一時停止
         */
        function pauseTimer() {
            if (timerId !== null) {
                clearInterval(timerId);
                timerId = null;
            }
        }

        /**
         * タイマーをリセット（25:00 に戻す）
         */
        function resetTimer() {
            // 動いていれば止める
            pauseTimer();
            // 残り時間を初期値に戻す
            remainingSeconds = INITIAL_SECONDS;
            // 画面表示もリセット
            updateDisplay();
        }

        /**
         * イベントリスナーの登録
         * ボタン操作やメモ入力と、JavaScriptの処理をひも付ける
         */
        function setupEventListeners() {
            startBtn.addEventListener('click', startTimer);
            pauseBtn.addEventListener('click', pauseTimer);
            resetBtn.addEventListener('click', resetTimer);

            // メモ欄は入力されるたびに保存（input イベント）
            memoInput.addEventListener('input', (event) => {
                saveMemo(event.target.value);
            });
        }

        // ページ読み込み時に一度だけ実行する初期化処理
        function init() {
            updateDisplay();    // まず 25:00 を表示
            loadFromStorage();  // もし保存済みのメモ・ポモ数があれば復元
            setupEventListeners(); // ボタンやメモと処理をひも付け
        }

        // ページが読み込まれたタイミングで init() を実行
        init();

        // ===== ここまでポモドーロタイマー用のJavaScript =====
    </script>
</body>
</html>
