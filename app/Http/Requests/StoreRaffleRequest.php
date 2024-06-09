<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class StoreRaffleRequest extends FormRequest
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
            'title' => ['required', 'min:3', 'max:255'],
            // 'start' => ['date_format:d-m-Y H:i'],
            // 'end' => ['date_format:d-m-Y H:i', 'after:start'],
            'price_1_coupon' => ['required', 'numeric', 'min:0.01', 'max:0.99'],
            'price_100_coupons' => ['required', 'numeric', 'min:0.01', 'max:0.99', 'lte:price_1_coupon'],
            'price_250_coupons' => ['required', 'numeric', 'min:0.01', 'max:0.99', 'lte:price_100_coupons'],
            'price_500_coupons' => ['required', 'numeric', 'min:0.01', 'max:0.99', 'lte:price_250_coupons'],
            'price_1000_coupons' => ['required', 'numeric', 'min:0.01', 'max:0.99', 'lte:price_500_coupons'],
            'price_5000_coupons' => ['required', 'numeric', 'min:0.01', 'max:0.99', 'lte:price_1000_coupons'],
            'price_10000_coupons' => ['required', 'numeric', 'min:0.01', 'max:0.99', 'lte:price_5000_coupons'],
            'description' => ['nullable', 'string'],
            'photo' => ['required', 'image', 'max:2048'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('start') && $this->filled('end')) {
                try {
                    $start = Carbon::createFromFormat('d-m-Y H:i', $this->start);
                    $end = Carbon::createFromFormat('d-m-Y H:i', $this->end);

                    if ($start->diffInHours($end) < 48) {
                        $validator->errors()->add('end', 'A data de término deve ser no mínimo 48 horas após a data de início.');
                    }
                } catch (\Exception $e) {
                    $validator->errors()->add('start', 'Formato de data inválido.');
                    $validator->errors()->add('end', 'Formato de data inválido.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'required' => 'Este campo é obrigatório.',
            'min' => 'Deve ter no mínimo :min caracteres.',
            'max' => 'Deve ter no máximo :max caracteres.',
            'date_format' => 'A data deve estar no formato d-m-Y H:i.',
            'after' => 'A data de término deve ser após a data de início.',
            'numeric' => 'Este campo deve ser um número.',
            'lte' => 'O preço deve ser menor ou igual ao do campo anterior.',
            'image' => 'O arquivo deve ser uma imagem.',
            'max.file' => 'A imagem não pode ser maior que :max kilobytes.',
            'price_1_coupon.min' => 'Deve ser no mínimo 1 centavo',
            'price_100_coupons.min' => 'Deve ser no mínimo 1 centavo',
            'price_250_coupons.min' => 'Deve ser no mínimo 1 centavo',
            'price_500_coupons.min' => 'Deve ser no mínimo 1 centavo',
            'price_1000_coupons.min' => 'Deve ser no mínimo 1 centavo',
            'price_500_coupons.min' => 'Deve ser no mínimo 1 centavo',
            'price_10000_coupons.min' => 'Deve ser no mínimo 1 centavo',
            'price_1_coupon.max' => 'Deve ser no máximo 99 centavos',
            'price_100_coupons.max' => 'Deve ser no máximo 99 centavos',
            'price_250_coupons.max' => 'Deve ser no máximo 99 centavos',
            'price_500_coupons.max' => 'Deve ser no máximo 99 centavos',
            'price_1000_coupons.max' => 'Deve ser no máximo 99 centavos',
            'price_500_coupons.max' => 'Deve ser no máximo 99 centavos',
            'price_10000_coupons.max' => 'Deve ser no máximo 99 centavos',
        ];
    }
}
