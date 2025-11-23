<?php

namespace Tests\Feature;

use Tests\TestCase;

class PomodoroPageTest extends TestCase
{
    /**
     * トップページ（/）でポモドーロ画面が表示されるか確認するテスト
     */
    public function test_top_page_shows_pomodoro_screen()
    {
        // 「/」にGETアクセスしてみる
        $response = $this->get('/');

        // ステータスコード200（正常）であることを確認
        $response->assertStatus(200);

        // 画面に「世界一シンプルなポモドーロ」という文字が含まれていることを確認
        $response->assertSee('世界一シンプルなポモドーロ');
    }
}
