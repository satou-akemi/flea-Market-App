docker compose ps
docker compose ps
exit
php artisan serve --host=0.0.0.0 --port=8000
exit
exit
ls database/migrations
exit
php artisan tinker
php artisan tinker
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan tinker
php artisan env
ls -la ./docker/mysql/data
exit
php artisan migrate
exit
docker exec -it fleamarket-app-mysql-1 ls /tmp/
fleamarket-app-mysql-1 ls /tmp/
exit
php artisan migrate:fresh
exit
php artisan migrate
exie
exit
php artisan migrate
exit
php artisan migrate
exit
docker-compose exec php bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
ls l database
ls -l database
grep -rl "class CreateUsersTable" database/migrations
grep -rl "class CreateUsersTable" database/migrations
php artisan migrate
php artisan db:seed
docker ps
php artisan tinker
docker exec -it your_laravel_container_name ping mailhog
exit
ls .env.testing
cat .env.testing | grep DB_DATABASE
exit
cat .env.testing | grep DB_DATABASE
docker exec -it fleamarket-app-php-1 sh -c "getent hosts mailhog"
docker-compose up -d --build
exit
php artisan tinker
php artisan test
exit
exit
php artisan key:generate --env=testing
php artisan migrate --env=testing
php artisan test
exit
php artisan test
php artisan test filter--ListingTest
php artisan test --filter=ListingTest
php artisan test --filter=ListingTest
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear
$product = App\Models\Product::find(1);
php artisan tinker
php artisan storage:link
php artisan tinker
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan route:list
php artisan tinker
storage/logs/laravel.log
tail -f storage/logs/laravel.log
tail -f storage/logs/laravel.log
tail -f storage/logs/laravel.log
php artisan tinker
tail -f storage/logs/laravel.log
tail -f storage/logs/laravel.log
php artisan tinker
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan tinker
exit
php artisan tinker
php artisan tinker
php artisan queue:work
php artisan route:list | grep login
php artisan tinker
exit
php artisan tinker
php artisan tinker
tail -n 50 storage/logs/laravel.log
php artisan config:clear && php artisan route:clear
tail -n 100 storage/logs/laravel.log
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer update laravel/fortify
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//商品関連
Route::get('/',[ProductController::class,'index'])->name('product.index');
Route::get('/product',[ProductController::class,'index'])->name('products.index');
Route::get('/sell',[ProductController::class,'listing'])->name('product.listing');
Route::post('/sell',[ProductController::class,'store'])->name('product.store');
//出品
Route::get('/product/{id}',[ProductController::class,'show'])->name('product.show');
//購入
Route::get('/order/create/{id}',[OrderController::class,'create'])->name('order.create');
Route::post('/order/store',[OrderController::class,'store'])->name('order.store');
Route::get('/home', [OrderController::class, 'index'])->name('home');
//送付住
Route::middleware(['auth'])->group(function () {
Route::get('/address',[AddressController::class,'edit'])->name('address.edit');
//更新ボタン処理
Route::put('/address',[AddressController::class,'update'])->name('address.update');
Route::get('/order/purchase/{id}', [OrderController::class, 'purchase'])->name('order.purchase');
});
//認証関連
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
//Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('guest')->name('login');
//Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
//プロフィール関連
Route::middleware(['auth'])->group(function () {
Route::get('/setup',[ProfileController::class,'setup'])->name('profile.setup');//setup入るとき->withoutMiddleware(['auth']);
Route::post('/update',[ProfileController::class,'update'])->name('profile.setup.update');
Route::get('/mypage/profile',[ProfileController::class,'edit'])->name('profile.edit');
Route::get('/mypage',[ProfileController::class,'show'])->name('mypage');//
Route::put('/mypage/profile',[ProfileController::class,'update'])->name('profile.update');
Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});
//いいねコメント機能
Route::post('/like/{id}',[LikeController::class,'store'])->name('like');
Route::get('/like/{id}', [LikeController::class, 'show']);
Route::post('/comment/{id}',[CommentController::class,'store'])->name('comment')->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::get('/order/{id}', [OrderController::class, 'create'])->name('order.create');
    //Route::get('/order/create/{id}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
});
php artisan route:list | grep login
$user = App\Models\User::find(21);
php artisan tinker
cd resources/views
touch thanks.blade.php
chmod -R 777 ./. *
sudo chmod -R 777 /path/to/resources/views
whoami
ls -la /path/to/resources/views
pwd
ls -la /var/www/html/resources/views
pwd
ls -la var/www/resources/views
ls -la /var/www/resources/views
ls -la /var/www/resources/views
sudo chown -R www-data:www-data /var/www/resources/views
su -
chown -R www-data:www-data /var/www/resources/views
exit
cd resources/views
cd ../../
cd public
touch css/thanks.css
chmod -R 777 ./.*
php artisan tinker
cs ../
cd ../
php artisan tinker
git status
exit
