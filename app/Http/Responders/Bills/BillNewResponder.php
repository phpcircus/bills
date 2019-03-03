<?php

namespace App\Http\Responders\Bills;

use Illuminate\Support\Facades\View;
use BrightComponents\Responder\Responder;

class BillNewResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function respond()
    {
        return View::component('BillNew');
    }
}
