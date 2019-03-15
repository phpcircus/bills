<?php

namespace App\Services\Summary;

use App\Models\Bill;
use BrightComponents\Services\Traits\SelfCallingService;

class SummaryIndexService
{
    use SelfCallingService;

    /** @var \App\Models\Bill */
    private $model;

    /**
     * Construct a new SummaryIndexService.
     *
     * @param  \App\Models\Bill  $model
     */
    public function __construct(Bill $model)
    {
        $this->model = $model;
    }

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run()
    {
        $overdue = $this->model->overdueBills();
        $week = $this->model->billsDueWithinOneWeek();

        return [
            'overdue' => [
                'total' => '$'.$overdue->sum('amount'),
                'bills' => $overdue,
            ],
            'week' => [
                'total' => '$'.$week->sum('amount'),
                'bills' => $week,
            ],
        ];
    }
}
