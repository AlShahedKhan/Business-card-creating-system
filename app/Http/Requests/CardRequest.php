<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
            'first_name'          => 'nullable|string|max:25',
            'last_name'           => 'nullable|string|max:25',
            'company_name'        => 'nullable|string|max:50',
            'position'            => 'nullable|string|max:50',
            'group_or_individual' => 'nullable|in:group,individual',
            'emails'              => 'nullable|array',
            'emails.*'            => 'nullable|email|max:50',
            'phones'              => 'nullable|array',
            'phones.*'            => 'nullable|string|max:20',
            'websites'            => 'nullable|array',
            'websites.*'          => 'nullable|url|max:100',
            'social_media_links'  => 'nullable|array',
            'social_media_links.*' => 'nullable|url|max:100',
            'address_logo'        => 'nullable|image|mimes:jpg,jpeg,png,gif', // Updated validation for file upload
            'address'             => 'nullable|string|max:255',
        ];
    }
}
