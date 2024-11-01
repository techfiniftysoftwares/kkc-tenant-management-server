<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Update this with your authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
