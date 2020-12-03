<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaff extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name'     => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'pastor'   => 'required|integer',
            'bio'      => 'nullable|string',
            'image'    => 'file|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages() {
        return [
            'image.file' => 'Invalid file type for Profile Pic',
            'image.mimes' => 'Profile pic must be a jpeg, png, or jpg file',
            'image.max'   => 'Profile pic can\'t be more than 2MB'
        ];
    }
}
