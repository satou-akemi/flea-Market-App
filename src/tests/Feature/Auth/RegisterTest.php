<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register()
    {
        $response = $this->post('/register',[
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors(['name']);
        $errors = session('errors')->get('name');
        $this->assertContains('お名前を入力してください',$errors);
    }

    public function test_アドレスバリデーション()
    {
        $response = $this->post('/register',[
            'name' => 'テスト太郎',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors(['email']);
        $errors = session('errors')->get('email');
        $this->assertContains('メールアドレスを入力してください',$errors);
    }

    public function test_パスワードバリデーション()
    {
        $response = $this->post('/register',[
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors(['password']);
        $errors = session('errors')->get('password');
        $this->assertContains('パスワードを入力してください',$errors);
    }

    public function test_パスワード8文字以上バリデーション()
    {
        $response = $this->post('/register',[
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'dami123',
            'password_confirmation' => 'dami123',
        ]);
        $response->assertSessionHasErrors(['password']);
        $errors = session('errors')->get('password');
        $this->assertContains('パスワードは８文字以上で入力してください',$errors);
    }

    public function test_確認パスワードバリデーション()
    {
        $response = $this->post('/register',[
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'passwors',
        ]);
        $response->assertSessionHasErrors(['password']);
        $errors = session('errors')->get('password');
        $this->assertContains('パスワードと一致しません',$errors);
    }

    public function test_全一致ログイン画面遷移()
    {
        $response = $this->post('/register',[
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(url('/setup'));
    }
}
