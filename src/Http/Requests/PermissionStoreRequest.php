<?php
/**
 * PermissionStoreRequest.php
 * Created by rn on 11/13/2017 7:29 AM.
 */

namespace App\Components\Passerby\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionStoreRequest extends FormRequest
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