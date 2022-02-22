<?php

namespace App\Http\Requests;

use App\Rules\CheckString;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class PostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['bail', new CheckString, Rule::unique('posts'), 'required', 'max:255', 'string'],
            'image' => 'image',
            'thumbnail' => 'image',
            'body' => 'required',
        ];
    }
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
