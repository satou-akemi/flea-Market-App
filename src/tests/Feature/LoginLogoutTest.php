<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginLogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_メールアドレスバリデーション()
    {
        $response = $this->post('/login',[
            'email' => '',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors(['email']);
        $errors = session('errors')->get('email');
        $this->assertContains('メールアドレスを入力してください',$errors);
    }

    public function test_パスワードバリデーション(){
        $response = $this->post('/login',[
            'email' => 'test@example.com',
            'password' => '',
        ]);
        $response->assertSessionHasErrors(['password']);
        $errors = session('errors')->get('password');
        $this->assertContains('パスワードを入力してください',$errors);
    }

    public function test_入力情報エラー(){
        $response = $this->post('/login',[
            'email' => 'unknown@example.com',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors(['email']);
        $errors = session('errors')->get('email');
        $this->assertStringContainsString('ログイン情報が登録されていません',$errors[0]);
    }

    public function test_入力情報一致(){
        $response = $this->post('/login',[
            'email' => 'unknown@example.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/');
    }

    public function test_ログアウト(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
