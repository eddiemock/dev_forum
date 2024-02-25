User
<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\LocalizationController;
use App\Http\Middleware\Localization;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AdminController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[SiteController::class,'index']);
Route::get('/login', [SiteController::class, 'login'])->middleware('protectedpage')->name('login');
Route::post('/login',[SiteController::class,'confirm_login']);
Route::get('/register',[SiteController::class,'register'])->middleware('protectedpage');
Route::post('/register',[SiteController::class,'register_confirm']);
Route::get('/logout', [SiteController::class, 'logout']);

Route::post('/new_discussion',[DiscussionController::class,'confirm_new_discussion']);
Route::get('/new_discussion',[DiscussionController::class,'new_discussion']);
Route::get('/dashboard',[DiscussionController::class,'dashboard']);
Route::get('/detail/{id}',[DiscussionController::class,'detail'])->where('id','^\d+$');
Route::get('/delete/{id}',[DiscussionController::class,'delete'])->where('id','^\d+$');
Route::get('/edit/{id}',[DiscussionController::class,'edit_post'])->where('id','^\d+$');
Route::post('/update_post',[DiscussionController::class,'update_post']);

Route::post('/detail/{discussion}/comments', [CommentsController::class, 'store']);


Route::post('/detail/{discussion}/like', [LikeController::class, 'like'])->name('discussion.like');
Route::post('/detail/{discussion}/unlike', [LikeController::class, 'unlike'])->name('discussion.unlike');




Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/comments', [AdminController::class, 'comments'])->name('admin.comments');
    Route::post('/comment/approve/{id}', [AdminController::class, 'approveComment'])->name('admin.comment.approve');
    Route::delete('/comment/delete/{id}', [AdminController::class, 'deleteComment'])->name('admin.comment.delete');
});


Route::get('/{lang?}',function ($lang ='en'){
    return view('/');
});

Route::get('lang/{language}',[LocalizationController::class,'index']);


