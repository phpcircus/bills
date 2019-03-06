<?php

namespace App\Http\Responders;

use App\Models\Bill;
use Illuminate\Support\Facades\View;
use BrightComponents\Responder\Responder;

class LandingPageResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function respond()
    {
        return View::component('Dashboard', [
            'bills' => Bill::orderBy('due', 'asc')->where('paid', false)->get()->toArray(),
        ]);
    }
}
