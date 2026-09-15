<?php

use App\Http\Controllers\Admin\AwardController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\NewsArticleController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SpeakerController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Note: deliberately not using the 'guest' middleware here — its default
// redirect target is the public 'home' route, which would override the
// LoginController's own (correct) redirect to the admin dashboard for an
// already-authenticated user.
Route::get('/admin/login', [LoginController::class, 'create'])->name('login');
Route::post('/admin/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/admin/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('pages/home', [PageContentController::class, 'editHome'])->name('pages.home');
    Route::put('pages/home', [PageContentController::class, 'updateHome'])->name('pages.home.update');
    Route::get('pages/about', [PageContentController::class, 'editAbout'])->name('pages.about');
    Route::put('pages/about', [PageContentController::class, 'updateAbout'])->name('pages.about.update');
    Route::get('pages/contact', [PageContentController::class, 'editContact'])->name('pages.contact');
    Route::put('pages/contact', [PageContentController::class, 'updateContact'])->name('pages.contact.update');

    Route::resource('services', ServiceController::class)->except('show');
    Route::patch('services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
    Route::patch('services/{service}/toggle-featured', [ServiceController::class, 'toggleFeatured'])->name('services.toggle-featured');

    Route::resource('events', EventController::class)->except('show');
    Route::resource('awards', AwardController::class)->except('show');
    Route::resource('speakers', SpeakerController::class)->except('show');
    Route::resource('gallery', GalleryItemController::class)->except('show')->parameters(['gallery' => 'galleryItem']);
    Route::resource('news', NewsArticleController::class)->except('show')->parameters(['news' => 'newsArticle']);
    Route::resource('partners', PartnerController::class)->except('show');
    Route::resource('testimonials', TestimonialController::class)->except('show');

    Route::get('registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('registrations/{registration}', [RegistrationController::class, 'show'])->name('registrations.show');
    Route::match(['put', 'patch'], 'registrations/{registration}', [RegistrationController::class, 'update'])->name('registrations.update');
    Route::delete('registrations/{registration}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');

    Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::delete('contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
});
