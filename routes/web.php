<?php

use Illuminate\Support\Facades\Route;



Route::get('/', [App\Http\Controllers\User\IndexController::class, 'index'])->name('user.index');



Route::get('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\User\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'register']);
Route::get('/password/reset', [App\Http\Controllers\User\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [App\Http\Controllers\User\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [App\Http\Controllers\User\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [App\Http\Controllers\User\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/password/confirm', [App\Http\Controllers\User\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/password/confirm', [App\Http\Controllers\User\Auth\ConfirmPasswordController::class, 'confirm']);
Route::get('/email/verify', [App\Http\Controllers\User\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\User\Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [App\Http\Controllers\User\Auth\VerificationController::class, 'resend'])->name('verification.resend');



Route::group(['middleware' => 'verified'],function () {
    Route::get('/dashboard', [App\Http\Controllers\User\UserController::class, 'index'])->name('user.dashboard');
    
    
    
    Route::get('/edit-info', [App\Http\Controllers\User\UserController::class, 'edit_info'])->name('user.edit_info');
    Route::post('/edit-info', [App\Http\Controllers\User\UserController::class, 'update_info'])->name('user.update_info');
    Route::post('/edit-password', [App\Http\Controllers\User\UserController::class, 'update_password'])->name('user.update_password');
    
    Route::get('/create-post', [App\Http\Controllers\User\UserController::class, 'create_post'])->name('user.post.create');
    Route::post('/create-post', [App\Http\Controllers\User\UserController::class, 'store_post'])->name('user.post.store');
    
    Route::get('/edit-post/{post_id}', [App\Http\Controllers\User\UserController::class, 'edit_post'])->name('user.post.edit');
    Route::post('/edit-post/{post_id}', [App\Http\Controllers\User\UserController::class, 'update_post'])->name('user.post.update');
    
    Route::delete('/delete-post/{post_id}', [App\Http\Controllers\User\UserController::class, 'destroy_post'])->name('user.post.destroy');
    Route::post('/delete-post-media/{media_id}', [App\Http\Controllers\User\UserController::class, 'destroy_post_media'])->name('user.post.media.destroy');
    


    Route::get('/comments', [App\Http\Controllers\User\UserController::class, 'show_comments'])->name('user.comments');
    Route::get('/edit-comments/{comment_id}', [App\Http\Controllers\User\UserController::class, 'edit_comment'])->name('user.comment.edit');
    Route::put('/edit-comments/{comment_id}', [App\Http\Controllers\User\UserController::class, 'update_comment'])->name('user.comment.update');
    
    Route::delete('/delete-comment/{comment_id}', [App\Http\Controllers\User\UserController::class, 'destroy_comment'])->name('user.comment.destroy');
});



Route::get('/contact-us', [App\Http\Controllers\User\IndexController::class, 'contact'])->name('user.contact');
Route::post('/contact-us', [App\Http\Controllers\User\IndexController::class, 'store_contact'])->name('user.do_contact');
Route::get('/category/{category_slug}', [App\Http\Controllers\User\IndexController::class, 'category'])->name('user.category');
Route::get('/archive/{data}', [App\Http\Controllers\User\IndexController::class, 'archive'])->name('user.archive');
Route::get('/author/{username}', [App\Http\Controllers\User\IndexController::class, 'author'])->name('user.author');
Route::get('/search', [App\Http\Controllers\User\IndexController::class, 'search'])->name('user.search');
Route::get('/{post}', [App\Http\Controllers\User\IndexController::class, 'post_show'])->name('posts.show');
Route::post('/{post}', [App\Http\Controllers\User\IndexController::class, 'store_comment'])->name('posts.add_comment');
