<?php

$this->group(['middleware' => ['auth', 'verified']], function ($router) {
    $router->redirect('/home', '/');
    $router->get('/', LandingPage::class);

    // Bill Routes
    $router->get('/bill/new', Bills\BillNew::class);
    $router->post('/bill', Bills\BillStore::class);
});
