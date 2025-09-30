<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSongRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'duration' => 'sometimes|required|integer',
            'album_id' => 'sometimes|required|integer|exists:albums,id',
        ];
    }
}
