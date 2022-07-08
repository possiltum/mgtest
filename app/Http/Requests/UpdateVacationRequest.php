<?php

namespace App\Http\Requests;


use App\Models\User;
use App\Models\Vacation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateVacationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize (Request $request)
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules ()
    {
        return [
            'fix' => ['boolean'],
            'start' => ['date'],
            'stop' => ['date'],

            'start_ts' => ['lte:stop_ts'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation ()
    {
        if($this->has('start') || $this->has('stop'))
        {
            $start = Carbon::parse($this->start);
            $stop = Carbon::parse($this->stop);

            $this->merge([
                'start' => $start,
                'stop' => $stop,
                'start_ts' => $start->getTimestamp(),
                'stop_ts' => $stop->getTimestamp(),
            ]);
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */



}
