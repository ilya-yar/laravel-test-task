<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(title="Запрос на обновлене Campaign", required={"name"})
 */
class UpdateCampaignRequest extends FormRequest
{
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
            'name' => 'required|string|max:255',
            'target_url' => 'required|string|max:255',
            'status' => 'required|in:enabled,disabled',
            'category' => 'nullable|in:adult,mainstream',
            'format' => 'nullable|in:pops,push',
            'bid_type' => 'required|in:cpc,cpm',
            'bid' => 'required|numeric|min:0',
            'budget_daily' => 'required|numeric|min:0',
            'budget_total' => 'required|numeric|min:0',
            'platform' => 'required|in:mobile,desktop',
            'os' => 'required|in:ios,android',
        ];
    }
}
