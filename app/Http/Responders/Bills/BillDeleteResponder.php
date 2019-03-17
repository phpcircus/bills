<?php

namespace App\Http\Responders\Bills;

use BrightComponents\Responder\Responder;

class BillDeleteResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return response()->json(['result' => 'OK'], 200);
    }
}
