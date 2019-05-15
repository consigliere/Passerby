<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/14/19 12:59 PM
 */

/**
 * AuthLoginRequest.php
 * Created by @anonymoussc on 05/14/2019 12:56 PM.
 */

namespace App\Components\Passerby\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
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