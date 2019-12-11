<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        'title' => 'required|max:50',
        'start_line' => 'required||after_or_equal:today',
        'dead_line' => 'required|after_or_equal:start_line',
      ];
    }

    public function messages()
    {
      return [
        'start_line.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
      ]; 
    }
}
