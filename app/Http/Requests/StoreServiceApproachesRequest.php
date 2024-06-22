<?php

namespace App\Http\Requests;

use App\Models\ServiceApproaches;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreServiceApproachesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('create', new ServiceApproaches);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // validation rules approach required
            'approach' => ['required', 'string'],
            // validation rules approach_ar required
            'approach_ar' => ['required', 'string'],
            // validation rules icon required and image
            'icon' => ['required', 'image'],
        ];
    }
}
