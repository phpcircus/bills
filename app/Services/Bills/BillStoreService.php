<?php

namespace App\Services\Bills;

use App\Models\Bill;
use BrightComponents\Services\Traits\SelfCallingService;

class BillStoreService
{
    use SelfCallingService;

    /** @var \App\Services\Bills\BillStoreValidation */
    protected $validator;

    /** @var \App\Models\Bill */
    protected $model;

    /**
     * Construct a new BillStoreService.
     *
     * @param  \App\Services\Bills\BillStoreValidation  $validator
     * @param  \App\Models\Bill  $model
     */
    public function __construct(BillStoreValidation $validator, Bill $model)
    {
        $this->validator = $validator;
        $this->model = $model;
    }

    /**
     * Handle the call to the service.
     *
     * @return \App\Models\Bill
     */
    public function run(array $attributes)
    {
        session()->flash('notification', 'Bill was successfully created!');

        return $this->model->create($this->validator->validate($attributes));
    }
}
