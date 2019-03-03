<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Http\Responders\LandingPageResponder;

class LandingPage extends Action
{
    /** @var \App\Http\Responders\LandingPageResponder */
    protected $responder;

    /**
     * Construct a new LandingPage action.
     *
     * @param  \App\Http\Responders\LandingPageResponder  $responder
     */
    public function __construct(LandingPageResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return $this->responder;
    }
}
