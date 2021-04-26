<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ChapterRequest extends Request
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
            'txtName' => 'required|unique:chapters,name,'.$this->id,
            'txtSubname' => 'required',
            'txtContent' => 'required'
        ];
    }

    /**
     * @return array
     */

    public function messages()
    {
        return [
            'txtName.required'    => 'You must enter the chapter name!',
            'txtSubname.required' => 'You must enter the chapter item name!',
            'txtContent.required' => 'You must enter the content of the chapter!',
        ];
    }
}
