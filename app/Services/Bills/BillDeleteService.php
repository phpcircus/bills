<?php

namespace App\Services\Bills;

use App\Models\Bill;
use BrightComponents\Services\Traits\SelfCallingService;

class BillDeleteService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run(Bill $bill)
    {
        return $bill->delete();
    }
}
