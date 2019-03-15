<?php

namespace App\Http\Actions\Summary;

use BrightComponents\Actions\Action;
use App\Services\Summary\SummaryIndexService;
use App\Http\Responders\Summary\SummaryIndexResponder;

class Index extends Action
{
    /** @var \App\Http\Responders\Summary\SummaryIndexResponder */
    private $responder;

    /**
     * Construct a new Summary Index action.
     *
     * @param  \App\Http\Responders\Summary\SummaryIndexResponder  $responder
     */
    public function __construct(SummaryIndexResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        return $this->responder->withPayload(SummaryIndexService::call());
    }
}
