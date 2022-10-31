<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
{
    const MIN_FILE_SIZE_KB = 0;
    const MAX_FILE_SIZE_KB = 10 * 1024;
    const MIN_IMAGE_WIDTH_PX = 100;
    const MAX_IMAGE_WIDTH_PX = 1000;
    const MIN_IMAGE_HEIGHT_PX = 100;
    const MAX_IMAGE_HEIGHT_PX = 1000;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $dimensions_rule = Rule::dimensions()
        ->minWidth(self::MIN_IMAGE_WIDTH_PX)
        ->maxWidth(self::MAX_IMAGE_WIDTH_PX)
        ->minHeight(self::MIN_IMAGE_HEIGHT_PX)
        ->maxHeight(self::MAX_IMAGE_HEIGHT_PX);

        $image_rule = File::image()
            ->min(self::MIN_FILE_SIZE_KB)
            ->max(self::MAX_FILE_SIZE_KB)
            ->dimensions($dimensions_rule);

        return [
            'title'       => 'required|max:255',
            'author_name' => 'required|max:255',
            'image'       => ['nullable', $image_rule],
            'body'        => 'nullable',
        ];
    }
}
