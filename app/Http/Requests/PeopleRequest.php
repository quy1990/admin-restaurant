<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeopleRequest extends FormRequest
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
            'invitation_id'  => 'required',
            'user_id'        => 'required',
            'restaurant_id'  => 'required',
            'reservation_id' => 'required',
            'email'          => 'required',
            'phone'          => 'required',
        ];
    }
}
