<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 2/27/19 5:27 PM
 */

/**
 * LoginRequest.php
 * Created by @anonymoussc on 10/22/2017 1:28 AM.
 */

namespace App\Components\Passerby\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }
}