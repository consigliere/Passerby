<?php
/**
 * PermissionCreateRequest.php
 * Created by @anonymoussc on 11/14/2017 4:26 PM.
 */

namespace App\Components\Passerby\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionCreateRequest extends FormRequest
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