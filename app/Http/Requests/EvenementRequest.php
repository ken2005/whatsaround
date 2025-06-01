<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvenementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'num_rue' => 'nullable|string|max:10',
            'allee' => 'nullable|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|string|max:5|min:5',
            'pays' => 'required|string|max:255',
            'date' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'diffusion' => 'required|integer|in:1,2,3',
            'categorie' => 'required|array',
            'categorie.*' => 'exists:categorie,id',
            'annonciateur' => 'nullable|boolean',
            'max_participants' => 'nullable|integer|min:1'
        ];
    }
}
