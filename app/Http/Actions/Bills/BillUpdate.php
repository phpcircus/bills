<?php

namespace App\Http\Actions\Bills;

use App\Models\Bill;
use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Services\Bills\BillUpdateService;
use App\Http\Responders\Bills\BillUpdateResponder;

class BillUpdate extends Action
{
    /** @var \App\Http\Responders\Bills\BillUpdateResponder */
    private $responder;

    /**
     * Construct a new BillUpdate action.
     *
     * @param  \App\Http\Responders\Bills\BillUpdateResponder  $responder
     */
    public function __construct(BillUpdateResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Invoke the BillUpdate action.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Bill $bill, Request $request)
    {
        BillUpdateService::call($bill, $request->all());

        return $this->responder;
    }
}
