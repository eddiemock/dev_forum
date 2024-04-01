<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CategoryController;
Use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ProfileController;
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

Auth::routes(['verify' => true]);


Route::get('/email/verify/{token}', [VerificationController::class, 'verify'])->name('verification.verify');

Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');

Route::get('/',[HomeController::class,'index']);
Route::get('/login', [HomeController::class, 'login'])->middleware('protectedpage')->name('login');
Route::post('/login',[HomeController::class,'confirm_login'])->name('login');
Route::get('/register',[HomeController::class,'register']);
Route::post('/register',[HomeController::class,'register_confirm']);
Route::post('logout', [HomeController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware('auth', 'verified')->group(function () {
Route::post('/categories/{category}/discussions', [DiscussionController::class, 'store'])->name('discussions.store');
Route::get('/categories/{category}/discussions/new', [DiscussionController::class, 'new_discussion'])->name('discussions.new');
Route::get('/categories/{category}/discussions/{id}', [DiscussionController::class, 'detail'])->name('discussions.detail');
Route::get('/categories/{category}/discussions/delete/{id}', [DiscussionController::class, 'delete'])->where('id', '^\d+$')->name('discussions.delete');
Route::get('/categories/{category}/discussions/edit/{id}', [DiscussionController::class, 'edit_post'])->where('id', '^\d+$')->name('discussions.edit');
Route::post('/categories/{category}/discussions/update/{id}', [DiscussionController::class, 'update_post'])->where('id', '^\d+$')->name('discussions.update');
Route::get('/dashboard',[HomeController::class,'dashboard']);
Route::post('/detail/{discussion}/comments', [CommentsController::class, 'store'])->name('discussions.comments.store');
Route::post('/comments/{comment}/like', [LikeController::class, 'like'])->name('comment.like');
Route::post('/comments/{comment}/unlike', [LikeController::class, 'unlike'])->name('comment.unlike');
Route::post('/update_post',[DiscussionController::class,'update_post']);
Route::get('logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/user/{id}/profile', [ProfileController::class, 'showProfile'])->name('pages.profile');
Route::get('/admin/user/{userId}/comments', [AdminController::class, 'getUserComments'])->name('admin.user.comments');


Route::post('report/comment/{comment}', [ReportController::class, 'reportComment'])->name('report.comment');



Route::middleware(['checkRole:administrator'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/comments', [AdminController::class, 'comments'])->name('admin.comments');
    Route::post('/comment/approve/{id}', [AdminController::class, 'approveComment'])->name('admin.comment.approve');
    Route::delete('/comment/delete/{id}', [AdminController::class, 'deleteComment'])->name('admin.comment.delete');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::post('/admin/send-support-email', [AdminController::class, 'sendSupportEmail'])->name('admin.sendSupportEmail');
});


Route::get('/moderate', function () {
    
})->middleware('checkRole:moderator,administrator');
});



Route::get('lang/{language}',[LocalizationController::class,'index']);


