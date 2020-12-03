<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreTeaching extends FormRequest
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
            'type'          => 'required|string|max:10',
            'title'         => 'required|string',
            'staff_id'      => 'integer',
            'speaker'       => 'required_without:staff_id|string|max:255|nullable',
            'video'         => 'url|string|nullable',
            'audio'         => 'url|string|nullable',
            'scripture'     => 'string',
            'status'        => 'string|max:50',
            'publish_date'  => 'required|date',
            'description'   => 'required|string|max:255',
            'ft_image'      => 'file|mimes:jpeg,png,jpg|max:2048'
        ];
    }


    public function messages() {
        return [
            'type.required'        => 'Failed to identify type',
            'title.required'       => 'Title can\'t be empty',
            'title.string'         => 'Title format invalid',
            'description.required' => 'Description required',
            'description.string'   => 'Description format invalid',
            'description.max'      => 'Description is too long',
            'speaker.max'          => 'Speaker name too long',
            'staff_id.integer'     => 'Staff invalid',
            'ft_image.max'         => 'Featured image can\'t be over 2MB',
            'ft_image.mimes'       => 'Featured image must be jpeg, jpg, or png',
            'ft_image.file'        => 'Featured image an invalid file'
        ];
    }
}
