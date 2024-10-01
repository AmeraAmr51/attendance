<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;
class UserRequest extends FormRequest
{
    use ResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        if(Route::currentRouteName() == 'user.login'){
        
            return [
                'employee_id' => 'required|integer|unique:users,employee_id',
                'password' => 'required|string',
            ];
        }
    }

}
