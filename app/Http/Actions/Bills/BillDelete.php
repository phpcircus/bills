<?php

namespace App\Http\Actions\Bills;

use App\Models\Bill;
use BrightComponents\Actions\Action;
use App\Services\Bills\BillDeleteService;
use App\Http\Responders\Bills\BillDeleteResponder;

class BillDelete extends Action
{
    /** @var \App\Http\Responders\Bills\BillDeleteResponder */
    private $responder;

    /**
     * Construct a new BillDelete action.
     *
     * @param  \App\Http\Responders\Bills\BillDeleteResponder  $responder
     */
    public function __construct(BillDeleteResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Bill  $bill
     *
     * @return  \Illuminate\Http\Response
     */
    public function __invoke(Bill $bill)
    {
        BillDeleteService::call($bill);

        return $this->responder;
    }
}
