<?php

Route::group(['middleware' => ['auth', 'verified']], function ($router) {
    $router->redirect('/home', '/');
    $router->get('/', LandingPage::class);

    // Bill Routes
    $router->group(['prefix' => 'api'], function ($router) {
        $router->get('/bills/new', Bills\BillNew::class);
        $router->post('/bills', Bills\BillStore::class)->middleware('cast.bool');
        $router->post('/bills/{bill}', Bills\BillUpdate::class)->middleware('cast.bool');
    });
});
