<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArtistRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'genre' => 'sometimes|required|string|max:255',
            'country' => 'sometimes|required|string|max:255',
        ];
    }
}
