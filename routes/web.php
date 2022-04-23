<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\frontend\editorController;
use App\Http\Controllers\Frontend\MenuController as FrontendMenuController;
use App\Http\Controllers\Frontend\ReservationController as FrontendReservationController;
use App\Http\Controllers\Frontend\FeedbackController as FrontendFeedbackController;
use \App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Frontend\WelcomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WelcomeController::class, 'index']);
Route::get('/categories', [FrontendCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [FrontendCategoryController::class, 'show'])->name('categories.show');
Route::get('/menus', [FrontendMenuController::class, 'index'])->name('menus.index');
Route::get('/reservation/step-one', [FrontendReservationController::class, 'stepOne'])->name('reservations.step.one');
Route::post('/reservation/step-one', [FrontendReservationController::class, 'storeStepOne'])->name('reservations.store.step.one');
Route::get('/reservation/step-two', [FrontendReservationController::class, 'stepTwo'])->name('reservations.step.two');
Route::post('/reservation/step-two', [FrontendReservationController::class, 'storeStepTwo'])->name('reservations.store.step.two');
Route::get('/thankyou', [WelcomeController::class, 'thankyou'])->name('thankyou');
Route::post('/feedbacks/feedbacks-ok' , [FrontendFeedbackController::class , 'store'])->name('feedbacks.store');
Route::get('/thankYou', [WelcomeController::class, 'feedbacks'])->name('feedbacks');
Route::get('/feedbacks/feedbacks-all' ,[FrontendFeedbackController::class , 'show'])->name('show-all');
Route::get('/about', [WelcomeController::class, 'aboutUs'])->name('aboutUs.index');
Route::get('/editor.create' , [editorController::class , 'create'])->name('editor.reservations.create');
Route::post('/editor.store' , [editorController::class , 'store'])->name('editor.reservations.store');
Route::delete('/editor.destroy/{id}' , [editorController::class , 'destroy'])->name('editor.reservations.destroy');
Route::get('/editor/edit/{id}' , [editorController::class , 'edit'])->name('editor.reservations.edit');
Route::post('/editor.update/{id}' , [editorController::class , 'update'])->name('editor.reservations.update');





Route::get('/dashboard', function () {
    return view('dashboard' ,[
        'reservations' => \App\Models\Reservation::all()
    ]);
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/menus', MenuController::class);
    Route::resource('/tables', TableController::class);
    Route::resource('/reservations', ReservationController::class);
    Route::resource('/offers', OfferController::class);
});

require __DIR__ . '/auth.php';
