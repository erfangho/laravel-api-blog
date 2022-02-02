<?php

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class IndexFilterRequest extends FormRequest
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
            'from' => 'date',
            'to' => 'date|after_or_equal:from',
            'date' => 'date',
            'author_id' => 'integer'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
