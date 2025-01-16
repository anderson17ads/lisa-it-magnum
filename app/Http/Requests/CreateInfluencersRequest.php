<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsInfluencerInCompaign;
use App\Rules\ExistsInfluencer;

class CreateInfluencersRequest extends FormRequest
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
            'id' => 'required|integer|exists:campaigns,id',
            'influencers' => 'required|array',
            'influencers.*' => [
                new ExistsInfluencer, 
                new ExistsInfluencerInCompaign
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'The id is required.',
            'id.exists' => 'The campaign does not exist.',
        ];        
    }

    /**
     * Override route parameters to include them in validation.
     *
     * @return array<string, mixed>
     */
    public function validationData(): array
    {
        return array_merge(
            $this->request->all(), 
            $this->route()->parameters()
        );
    }
}