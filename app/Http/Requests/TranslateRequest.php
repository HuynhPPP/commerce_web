<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranslateRequest extends FormRequest
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
            'translate_name' => 'required',
            'translate_canonical' => "required|unique:routers,canonical,{$this->id},module_id",

        ];
    }

    public function messages(): array
    {
        return [
            'translate_name.required' => 'Bạn chưa nhập tên ngôn ngữ !',
            'translate_canonical.required' => 'Bạn chưa nhập từ khoá của ngôn ngữ !',
            'translate_canonical.unique' => 'Từ khoá đã tồn tại ! Vui lòng chọn từ khoá khác.'
            
        ];
    }
}
