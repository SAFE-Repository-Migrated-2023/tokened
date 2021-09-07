<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
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
            'institution_name' => 'required|max:191',
            'degree_name' => 'required|max:191',
            'dates' => 'nullable|max:191',
            'description' => 'nullable|max:191',
            'certificate' => 'nullable|max:191',
            'upload' => 'nullable|image',
        ];
    }

}
