<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->hasRole('admin');
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:games,slug',
            'developer_id' => 'nullable|exists:developers,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'release_date' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
            'platforms' => 'nullable|array',
            'platforms.*' => 'exists:platforms,id',
        ];
    }
}
