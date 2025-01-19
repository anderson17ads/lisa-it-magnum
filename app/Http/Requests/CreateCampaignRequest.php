<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCampaignRequest extends FormRequest
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
            'name' => 'required|string|max:45|unique:campaigns,name',
            'budget' => 'required|numeric|min:0',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'influencers' => 'nullable|array',
            'influencers.*' => 'exists:influencers,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'This name is invalid.',
            'name.unique' => 'This name is already in use.',
            'name.max' => 'The maximum character limit is 45.',
            'budget.required' => 'Budget field is required.',
            'budget.numeric' => 'Budget field is not a number.',
            'description.required' => 'Description field is required.',
            'start_date.required' => 'Start date field is required.',
            'start_date.date' => 'Start date field is invalid.',
            'end_date.required' => 'End date field is required.',
            'end_date.date' => 'End date field is invalid.',
            'end_date.after_or_equal' => 'The final date field cannot be less than the start date',
            'influencers.*.exists' => 'Influencer :input does not exist.',
        ];        
    }
}