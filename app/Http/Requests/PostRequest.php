<?php

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'bail|unique:posts|required|max:255|string',
            'image' => 'image',
            'thumbnail' => 'image',
            'body' => 'required',
        ];
    }
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

}
