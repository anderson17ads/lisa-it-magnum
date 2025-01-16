<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInfluencerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:45',
            'instagram_user' => 'required|string|max:45|unique:influencers,instagram_user',
            'instagram_followers_count' => 'required|integer|min:0',
            'category_id' => 'required|integer|min:0',
            'campaigns' => 'nullable|array',
            'campaigns.*' => 'exists:campaigns,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'This name is invalid.',
            'name.max' => 'The maximum character limit is 45',
            'instagram_user.string' => 'Instagram username is invalid.',
            'instagram_user.required' => 'Instagram username is required.',
            'instagram_user.max' => 'The maximum character limit is 45',
            'instagram_user.unique' => 'This Instagram username is already in use.',
            'instagram_followers_count.required' => 'The followers number field is required.',
            'category_id.required' => 'The category field is required.',
            'category_id.integer' => 'This category is invalid.',
            'campaigns.*.exists' => 'Campaign :input does not exist.',
        ];        
    }
}