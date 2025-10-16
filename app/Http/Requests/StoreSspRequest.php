<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(title="Запрос на создание SSP", required={"name"})
 */
class StoreSspRequest extends FormRequest
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
            'uuid' => 'nullable|string|max:255',
            'uid' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'example_url' => 'nullable|string|max:255',
            'status' => 'required|in:enabled,disabled',
            'protocol' => 'required|in:xml/json,ortb',
            'bid_type' => 'required|in:cpc,cpm',
            'revshare' => 'required|integer|min:0',
            'type' => 'required|in:pops,push',
            'category' => 'required|in:adult,mainstream',
            'region' => 'required|in:europe,usa,asia',
            'qps' =>  'required|integer|min:0',
            'allow_feeds' => 'nullable|boolean',
            'allow_campaign' => 'nullable|boolean',
            'dsp_ids' => 'nullable|array',
            'campaign_ids' => 'nullable|array',
        ];
    }
}
