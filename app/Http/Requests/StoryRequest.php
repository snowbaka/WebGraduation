<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoryRequest extends Request
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
            'txtName' => 'required|unique:stories,name,'.$this->id,
            //'fImages'  => 'image',
            'intCategory' => 'required',
            'intAuthor'   => 'required',
            'txtSource'   => 'required',
            'fImages' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:9072'],

        ];
    }

    public function messages()
    {
        return [
            'txtName.required'    => 'You must enter the title of the story!',
            'txtName.unique'    => 'This article already exists!',
            'intCategory.required'=> 'You must choose the category!',
            'txtSource.required'=> 'You need to enter the source of the story!',
            'intAuthor.required'  => 'You have to choose an author!',
            'fImages.required' => 'Avatar cannot be empty',
            'fImages.image' => 'Picture format is not correct',
            'fImages.mimes' => 'Image size is too large',
        ];
    }
}
