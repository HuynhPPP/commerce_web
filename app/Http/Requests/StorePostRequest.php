<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'name' => 'required',
            'canonical' => 'required|unique:post_language',
            'post_catalogue_id' => 'gt:0',
         
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập ô tiêu đề nhóm bài viết !',
            'canonical.required' => 'Bạn chưa nhập ô đường dẫn !',
            'canonical.unique' => 'Đường dẫn đã tồn tại ! Vui lòng chọn đường dẫn khác.',
            'post_catalogue_id.gt' => 'Bạn chưa chọn danh mục cha !' 
        ];
    }
}
