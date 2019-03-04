<?php

namespace App\Models;

use App\Events\Models\Bill\BillCreating;

class Bill extends Unguarded
{
    /** @var array */
    protected $appends = ['severity', 'due_date', 'due_day_of_week'];

    /** @var array */
    protected $dates = ['due'];

    /** @var array */
    protected $dispatchesEvents = [
        'creating' => BillCreating::class,
    ];

    /** @var int */
    protected $scheduleAheadMonths = 2;

    /**
     * Get the severity, based on days until due, of the bill.
     *
     * @return string
     */
    public function getSeverityAttribute()
    {
        if ($this->paid) {
            return 'paid';
        }

        $days = $this->due->diffInDays(now(), false);

        if ($days >= 0) {
            return 'overdue';
        }
        if ($days < 0 && $days >= -7) {
            return 'high';
        }
        if ($days < -7 && $days >= -14) {
            return 'medium';
        }
        if ($days < -14) {
            return 'low';
        }
    }

    /**
     * Get the due date attribute for display..
     *
     * @return string
     */
    public function getDueDateAttribute()
    {
        return $this->due->toFormattedDateString();
    }

    /**
     * Get the due date attribute for display..
     *
     * @return string
     */
    public function getDueDayOfWeekAttribute()
    {
        return $this->due->format('l');
    }

    /**
     * Create a new Bill.
     *
     * @param  array  $attributes
     *
     * @return $this
     */
    public function createBill(array $attributes)
    {
        $bill = $this->create($attributes);

        if ($bill->recurring) {
            if ('weekly' === $bill->recurring_period) {
            }
        }
    }
}
