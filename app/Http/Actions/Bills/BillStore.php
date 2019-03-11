<?php

namespace App\Http\Actions\Bills;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Services\Bills\BillStoreService;

class BillStore extends Action
{
    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Request $request)
    {
        dump($request->all());
        BillStoreService::call($request->all());
    }
}
