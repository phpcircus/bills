<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
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
    protected $scheduleAheadMonths = 3;

    /**
     * Get the amount in USD.
     *
     * @return string
     */
    public function getAmountAttribute($value)
    {
        return money_format('%i', $value/100);
    }

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
        $bills = [];
        $bill = $this->create($attributes);
        $bills[] = $bill;

        if ($bill->recurring) {
            if ('weekly' === $bill->recurring_period) {
                $limit = Carbon::today()->addMonths($this->scheduleAheadMonths);
                $numWeeks = $limit->diffInWeeks($bill->due);
                Collection::times($numWeeks, function ($n) use ($bill, &$bills, $attributes) {
                    $attributes['due'] = $bill->due->addWeeks($n);
                    $bills[] = $this->create($attributes);
                });
            } elseif ('bi-weekly' === $bill->recurring_period) {
                $limit = Carbon::today()->addMonths($this->scheduleAheadMonths);
                $numWeeks = $limit->diffInWeeks($bill->due);
                Collection::times($numWeeks, function ($n) use ($bill, &$bills, $attributes) {
                    if (0 == $n % 2) {
                        $attributes['due'] = $bill->due->addWeeks($n);
                        $bills[] = $this->create($attributes);
                    }
                });
            } elseif ('monthly' === $bill->recurring_period) {
                $limit = Carbon::today()->addMonths($this->scheduleAheadMonths);
                $numMonths = $limit->diffInMonths($bill->due);
                Collection::times($numMonths, function ($n) use ($bill, &$bills, $attributes) {
                    $attributes['due'] = $bill->due->addMonths($n);
                    $bills[] = $this->create($attributes);
                });
            } elseif ('bi-monthly' === $bill->recurring_period) {
                $limit = Carbon::today()->addMonths($this->scheduleAheadMonths);
                $numMonths = $limit->diffInMonths($bill->due);
                Collection::times($numMonths, function ($n) use ($bill, &$bills, $attributes) {
                    if (0 == $n % 2) {
                        $attributes['due'] = $bill->due->addMonths($n);
                        $bills[] = $this->create($attributes);
                    }
                });
            }
        }

        return $bills;
    }

    public function updateBill(array $attributes)
    {
        if ($attributes['editAll']) {
            self::where('slug', $this->slug)->delete();

            return $this->createBill(Arr::except($attributes, 'editAll'));
        }

        return $this->update(Arr::except($attributes, 'editAll'));
    }
}
