<?php

namespace App\Services\Bills;

use App\Models\Bill;
use BrightComponents\Services\Traits\SelfCallingService;

class BillUpdateService
{
    use SelfCallingService;

    /**
     * Construct a new BillPaidService.
     */
    public function __construct()
    {
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Bill  $bill
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function run(Bill $bill, array $attributes)
    {
        $bill->update($attributes);
    }
}
