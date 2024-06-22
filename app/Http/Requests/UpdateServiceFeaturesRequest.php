<?php

namespace App\Http\Requests;

use App\Models\ServiceFeatures;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateServiceFeaturesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        $ServiceFeature=ServiceFeatures::find($this->route('service_feature'));//

        return $this->user()->can('update', $ServiceFeature);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
