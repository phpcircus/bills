<?php

namespace App\Listeners\Models\Bill;

use Illuminate\Support\Str;
use App\Events\Models\Bill\BillCreating;

class CreateBillSlug
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Models\Bill\BillCreating  $event
     */
    public function handle(BillCreating $event)
    {
        $event->bill->slug = Str::slug($event->bill->name, '-');
    }
}
