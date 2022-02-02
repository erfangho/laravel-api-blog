<?php

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'name' => 'required|string',
            'email'    => 'bail|required|email|unique:users,email',
            'password' => 'bail|required|string|min:6',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
