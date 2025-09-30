<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer',
            'artist_id' => 'sometimes|required|integer|exists:artists,id',
        ];
    }
}
