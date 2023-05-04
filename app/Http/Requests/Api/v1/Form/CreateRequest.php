<?php

namespace App\Http\Requests\Api\v1\Form;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Models\Input;

class CreateRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return  [
            'title' => 'required|string|max:255',
            'description' => 'string'
        ];
    }

    public function messages() {
        return [
            //
        ];
    }

    public function failedValidation(Validator $validator)
    {
       throw new HttpResponseException(response()->json([
         'status'    => 422,
         'message'   => $validator->errors()->first(),
       ]));
    }
}
