<?php

namespace App\Http\Requests;

use App\Models\Services;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreServicesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //use policy to check if user is authorized to create a service
        return Auth::user()->can('create', new Services);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $rules = [
            //validation rules
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'description_ar' => ['required', 'string'],
            //validate service_icon image
            'service_icon' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            //validate image
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            // validate type
            'type' => 'required',
        ];
        if (!$this->has('Framework_video_type') || !$this->filled('Framework_video_type')) {
            $rules['youtube_link'] = 'required|string'; // Required if checkbox not checked
            $rules['youtube_url'] = 'required|string'; // Required if checkbox not checked
        }
        else
        {
            $rules['framework_video'] = 'required'; // Required if checkbox checked

        }
        if (!$this->has('Framework_video_type_ar') || !$this->filled('Framework_video_type_ar')) {
            $rules['youtube_link_ar'] = 'required|string'; // Required if checkbox not checked
            $rules['youtube_url_ar'] = 'required|string'; // Required if checkbox not checked
        }
        else
        {
            $rules['framework_video_ar'] = 'required'; // Required if checkbox checked

        }
        return $rules;

    }
    /**
     * Custom validation messages (optional).
     *
     * @return array
     */
    public function messages()
    {
        return [
            'framework_video.required' => 'You need to upload a video file',
        ];
    }
}
