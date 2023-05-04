<?php

namespace App\Http\Requests\Api\v1\Input;

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
            'name' => 'required|string',
            'type' => 'required|in:button,checkbox,color,date,datetime-local,email,file,hidden,image,month,number,password,radio,range,reset,search,submit,tel,text,time,url,week'
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
