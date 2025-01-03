<?php

namespace App\Http\Requests;

use App\Models\Feedback;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFeedbackRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                Rule::in(Feedback::SUPPORTED_TYPES),
            ],
            'body' => [
                'required',
                'string',
                'max:1000',
            ],
            'data' => [
                'sometimes',
                'required',
                'array',
            ],
        ];
    }
}
