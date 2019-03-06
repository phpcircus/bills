<?php

namespace App\Services\Bills;

use Illuminate\Validation\Rule;
use App\Rules\RequiredIfRecurringRule;
use BrightComponents\Valid\ValidationService\ValidationService;

class BillStoreValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:4', Rule::unique('bills', 'name')],
            'amount' => ['numeric', 'min:1'],
            'due' => ['date_format:Y-m-d'],
            'recurring' => ['boolean'],
            'recurring_period' => ['nullable', 'in:weekly,bi-weekly,monthly,bi-monthly', new RequiredIfRecurringRule],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     *
     * @return array
     */
    public function filters()
    {
        return [
        ];
    }

    /**
     * Run any logic needed before validation.
     *
     * @return array
     */
    protected function beforeValidation()
    {
        if ('true' === $this->data['recurring']) {
            $this->data['recurring'] = true;
        }
        if ('false' === $this->data['recurring']) {
            $this->data['recurring'] = false;
        }

        return $this->data;
    }
}
