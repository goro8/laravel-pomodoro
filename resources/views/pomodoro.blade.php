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
        // ここに 2-5 のステップで
        // ・25分タイマーのカウントダウン
        // ・Start / Pause / Reset の動作
        // ・localStorage への保存／読み込み
        // を実装していく予定。
        //
        // 今は「HTMLと見た目のひな形だけ」のステップ（2-4）。
    </script>
</body>
</html>
