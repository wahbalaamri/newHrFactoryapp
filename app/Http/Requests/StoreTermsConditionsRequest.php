<?php

namespace App\Http\Requests;

use App\Models\TermsConditions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTermsConditionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('create', new TermsConditions());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'country' => ['required', 'integer', 'exists:countries,id'],
            'type' => ['required', 'string'],
            'content_ar' => ['required', 'string'],
            'content_en' => ['required', 'string'],
            'title_en' => ['required', 'string'],
            'title_ar' => ['required', 'string'],
        ];
    }
    /**
     * Custom validation messages .
     *
     * @return array
     */
    public function messages()
    {
        return [
            'country.required' => 'Country is required',
            'type.required' => 'Type is required',
            'content_ar.required' => 'Arabic content is required',
            'content_en.required' => 'English content is required',
            'title_en.required' => 'English title is required',
            'title_ar.required' => 'Arabic title is required',
        ];
    }
}
