<?php

namespace App\Http\Responders\Summary;

use Illuminate\Support\Facades\View;
use BrightComponents\Responder\Responder;

class SummaryIndexResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return View::component('Summary', [
            'data' => $this->payload,
        ]);
    }
}
