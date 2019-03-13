<?php

namespace App\Services\Bills;

use Illuminate\Validation\Rule;
use App\Rules\RequiredIfRecurringRule;
use BrightComponents\Valid\ValidationService\ValidationService;

class BillUpdateValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        dump('bill', $this->route('bill'));

        return [
            'name' => ['required', 'min:4', Rule::unique('bills', 'name')->ignore($this->route('bill'))],
            'amount' => ['numeric', 'min:1'],
            'due' => ['date_format:Y-m-d'],
            'recurring' => ['boolean'],
            'recurring_period' => ['in:none,weekly,bi-weekly,monthly,bi-monthly', new RequiredIfRecurringRule],
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
}
