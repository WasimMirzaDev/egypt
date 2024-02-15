<?php

use App\Http\Controllers\AdminExchangeRateController;
use App\Http\Controllers\NewExchangeRateController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('/switch-to/{template}', function ($name) {
    session()->put('template', $name);
    return to_route('home');
});

Route::get('/rates', function () {
    return response()->view('rates')->header('Content-Type', 'text/xml');
});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{ticket}', 'replyTicket')->name('reply');
    Route::post('close/{ticket}', 'closeTicket')->name('close');
    Route::get('download/{ticket}', 'ticketDownload')->name('download');
});



Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');
Route::get('download/exchange/pdf/{hash}/{id}', 'SiteController@downloadPdf')->name('download.exchange.pdf');

Route::post('/exchange/limits', [SiteController::class, 'getLimits'])->name('user.exchange.limits');
Route::get('/', [SiteController::class, 'index'])
    ->name('home');

Route::post('user/exchange/rates', [SiteController::class, 'getRates'])->name('user.exchange.rates');
Route::post('user/exchange/youSendRates', [SiteController::class, 'getRatesByYouSend'])->name('user.exchange.rates.you.send');
Route::post('user/exchange/youGetInputRates', [SiteController::class, 'getInputRates'])->name('user.getInput.rates');
Route::get('exchange/tracking', [SiteController::class,  'trackExchange'])->name('exchange.tracking');
Route::post('subscribe', [SiteController::class, 'subscribe'])->name('subscribe');

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/reviews', 'indexReviews')->name('indexReviews');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blog', 'blog')->name('blog');
    Route::get('faq', 'faq')->name('faq');
    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');
    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('exchange/tracking', 'trackExchange')->name('exchange.tracking');
    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
    Route::get('/{slug}', 'pages')->name('pages');

    Route::post('user/exchange/rates', 'getRates')->name('user.exchange.rates');
    Route::post('user/exchange/youSendRates', 'getRatesByYouSend')->name('user.exchange.rates.you.send');
    Route::post('user/exchange/youGetInputRates', 'getInputRates')->name('user.getInput.rates');

    Route::get('/exchange-rate', 'ExchangeRateController@index')->name('exchange.rate');
    Route::get('/rates', [App\Http\Controllers\RatesController::class, 'index']);

    Route::get('/admin/exchange-rates', 'ExchangeRateController@test')->name('admin.exchange-rates.index');

    Route::middleware('admin')->group(function () {
        Route::get('/admin/exchange-rates', [AdminExchangeRateController::class, 'index'])->name('exchange-rates.index');
        Route::get('/admin/exchange-rates/create', [AdminExchangeRateController::class, 'create'])->name('exchange-rates.create');
        Route::post('/admin/exchange-rates', [AdminExchangeRateController::class, 'store'])->name('exchange-rates.store');
        Route::get('/admin/exchange-rates/{id}/edit', [AdminExchangeRateController::class, 'edit'])->name('exchange-rates.edit');
        Route::put('/admin/exchange-rates/{id}', [AdminExchangeRateController::class, 'update'])->name('exchange-rates.update');


        Route::delete('/admin/exchange-rate/{id}', [AdminExchangeRateController::class, 'delete'])->name('exchange-rates.delete');

        Route::get('/admin/reviews', [\App\Http\Controllers\UserReviewController::class, 'show'])->name('show.reviews');
        Route::put('/admin/review/{id}', [\App\Http\Controllers\UserReviewController::class, 'approve'])->name('approve.review');
        Route::Delete('/admin/review/{id}', [\App\Http\Controllers\UserReviewController::class, 'destroy'])->name('destroy.review');
    });
});
// Redirect route
Route::redirect('/userregister', '/user/register', 301); // 301 for permanent redirect
// Redirect route
Route::redirect('/registerusers', '/register/users');

// This route should catch any other URLs with the format /{slug}
Route::get('/{slug}', [SiteController::class, 'pages'])->name('pages');
