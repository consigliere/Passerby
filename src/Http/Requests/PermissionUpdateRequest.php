<?php
/**
 * PermissionUpdateRequest.php
 * Created by rn on 11/14/2017 4:14 PM.
 */

namespace App\Components\Passerby\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:40',
        ];
    }
}