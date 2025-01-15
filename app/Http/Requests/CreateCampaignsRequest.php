<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsCompaignInInfluencer;
use App\Rules\ExistsCompaign;

class CreateCampaignsRequest extends FormRequest
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
            'id' => 'required|integer|exists:influencers,id',
            'campaigns' => 'required|array',
            'campaigns.*' => [
                new ExistsCompaign, 
                new ExistsCompaignInInfluencer
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'The id is required.',
            'id.exists' => 'The id does not exist.',
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