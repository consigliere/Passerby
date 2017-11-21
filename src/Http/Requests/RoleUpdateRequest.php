<?php
/**
 * RoleUpdateRequest.php
 * Created by rn on 11/19/2017 12:08 PM.
 */

namespace App\Components\Passerby\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'         => 'required',
            'display_name' => 'required',
        ];
    }
}