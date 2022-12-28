<?php

namespace App\Http\Requests\Quality;

use Illuminate\Foundation\Http\FormRequest;

class StoreQualityNonConformityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'code' =>'required|unique:quality_non_conformities',
            'label'=>'required',
            'failure_comment'=>'required',
            'causes_comment'=>'required',
            'correction_comment'=>'required',
        ];
    }
}
