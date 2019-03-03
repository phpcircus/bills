<?php

namespace App\Http\Actions\Bills;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Http\Responders\Bills\BillNewResponder;

class BillNew extends Action
{
    /** @var \App\Http\Responders\Bills\BillNewResponder */
    protected $responder;

    /**
     * Construct a new BillNew action.
     *
     * @param  \App\Http\Responders\Bills\BillNewResponder  $responder
     */
    public function __construct(BillNewResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Request $request)
    {
        return $this->responder;
    }
}
