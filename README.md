Fleamarket App

##Laravel 環境構築
Fleamarket App

## Laravel 環境構築

● リポジトリをクローン  
● cp .env.example .env  
● docker-compose up -d --build  
● docker-compose exec php bash  
● composer install  
● php artisan key:generate  
● php artisan migrate  
● php artisan db:seed


## メールアドレス認証
会員登録後認証画面へ遷移認証はこちらボタンを押下すると勤怠打刻画面へ遷移します。
Mailhog使用
Mailhog認証サイト　http://localhost:8025
メールが届かない場合は再送ボタンを押下してください。

##テストユーザー情報
開発、動作確認用に用意したユーザーです
| 名前  | メールアドレス         | パスワード    | 役割           |
|-------|----------------------|-------------|----------------|
|  ユーザー1| user1@test.com    | password | 出品者         |
| ユーザー2   | user2@test.com      | password | 出品者         |
| ユーザー3 | user3@test.com    | password | 購入者 |

パスワードはすべて 'password' に設定しています。

### Stripeテスト用APIキー
テスト用に設定しているStripeキーです。
Stripeのテスト用キーは `.env` に設定されています。

- 公開可能キー（Publishable Key）: pk_test_51RaVQX2Q9hCCkoB2JBXOTz2IuVsV0F25wDZlfz5PLNJAMAghX2PL1fWbNLiojpIQTw7NPyd4lDM9bA4dPkCDC9MC00ZNdkC4Lf
- シークレットキー（Secret Key）: `STRIPE_SECRET`

##URL
● 開発画面 : http://localhost/  
● 新規登録 : http://localhost/register  
●phpMyAdmin : http://localhost:8080  

##使用技術
●PHP 7.4.9  
●Laravel 8.83 29  
●MySQL 8.0.26  

![ER図](resources/views/readme.drawio.png)


