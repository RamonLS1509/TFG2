<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGameRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->hasRole('admin');
    }

    public function rules()
    {
        $gameId = $this->route('game')->id ?? null;
        return [
            'title' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes','required','string', Rule::unique('games','slug')->ignore($gameId)],
            'developer_id' => 'nullable|exists:developers,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'release_date' => 'nullable|date',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
            'platforms' => 'nullable|array',
            'platforms.*' => 'exists:platforms,id',
        ];
    }
}
