<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnderecoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $endereco = $this->route('endereco');

        return $this->user() && $this->user()->can('update', $endereco);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'logradouro' => ['required', 'string', 'max:60'],
            'numero' => ['required', 'string', 'max:15'],
            'bairro' => ['required', 'string', 'max:30'],
            'cidade' => ['required', 'string', 'max:30'],
            'estado' => ['required', 'string', 'max:30'],
            'cep' => ['required', 'string', 'max:9'],
            'complemento' => ['nullable', 'string', 'max:100'],
        ];
    }
}
