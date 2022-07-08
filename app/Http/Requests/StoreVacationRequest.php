<?php

namespace App\Http\Requests;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreVacationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize (Request $request)
    {
        return Auth::id() == $request->input('user_id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules ()
    {
        return [
            'user_id' => ['required', 'integer'],
            'start' => ['required', 'date'],
            'stop' => ['required', 'date'],
            'start_ts' => ['lt:stop_ts'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
//    public function withValidator ($validator)
//    {
//        $validator->after(function ($validator)
//        {
//            if ($this->checkStartStop())
//            {
//                $validator->errors()->add('field', '');
//            }
//        });
//    }

//    private function checkStartStop (Request $request)
//    {
//        $start = Carbon::parse($request->start);
//        $stop = Carbon::parse($request->stop);
//
//        return $start < $stop;
//    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'start_ts' => Carbon::parse($this->start)->getTimestamp(),
            'stop_ts' => Carbon::parse($this->stop)->getTimestamp(),
        ]);
    }


    public function messages()
    {
        return [
            'start_ts.lte' => 'A message is !!!!',
        ];
    }
}
