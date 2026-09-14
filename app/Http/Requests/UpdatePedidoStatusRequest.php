<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePedidoStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $pedido = $this->route('pedido');

        return $this->user() && $this->user()->can('updateStatus', $pedido);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in([
                    'aguardando_confirmacao',
                    'em_preparo',
                    'enviado',
                    'entregue',
                    'cancelado',
                ]),
            ],
        ];
    }
}
