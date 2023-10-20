<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddemployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'x' => 'required',
            'xnip' => 'required',
            'xname' => 'required',
            'xemail' => 'required',
            'xphone_number' => 'required',
            'xaddress' => 'required',
            'xpurity' => 'required'
        ];
    }
}