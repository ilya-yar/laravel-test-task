<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(title="Запрос на обновление DSP")
 */
class UpdateDspRequest extends FormRequest
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
            'comment' => 'nullable|string|max:255',
            'status' => 'required|in:active,declined',
            'country' =>  'nullable|string|max:255',
            'balance' => 'nullable|numeric',
            'max_rps' =>  'nullable|integer',
            'type' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'protocol' => 'nullable|string|max:255',
            'feed_parser' => 'nullable|string|max:255',
            'customizer' => 'nullable|string|max:255',
            'ref_spoofing' => 'nullable|string|max:255',
            'target_by_pseudosites' => 'nullable|in:active,disabled',
            'ref_spoofing_host' => 'nullable|string|max:255',
            'bid_type' => 'nullable|string|max:255',
            'revshare' => 'nullable|numeric',
            'max_clicks_per_ip24' =>  'nullable|integer',
            'ip_mismatch' =>  'nullable|boolean',
            'proxy' =>  'nullable|boolean',
            'no_js' =>  'nullable|boolean',
            'iframe' =>  'nullable|boolean',
            'headless' =>  'nullable|boolean',
            'tz_mismatch' =>  'nullable|boolean',
            'ua_mismatch' =>  'nullable|boolean',
            'ref_mismatch' =>  'nullable|boolean',
            'double_click' =>  'nullable|boolean',
            'rps' =>  'nullable|integer',
            'delay_request_optimization' => 'nullable|string|max:255',
            'api_token' => 'nullable|string|max:255',
            'feed_api_token' => 'nullable|string|max:255',
        ];
    }
}
