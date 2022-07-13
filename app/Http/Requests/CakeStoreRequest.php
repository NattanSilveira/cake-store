<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CakeStoreRequest extends FormRequest
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

    public function validator($factory)
    {
        return $factory->make(
            $this->sanitize(), $this->container->call([$this, 'rules']), $this->messages()
        );
    }

    public function sanitize()
    {
        $this->merge([
            'nome' => $this->json('nome'),
            'peso' => $this->json('peso'),
            'qtd_disponivel' => $this->json('qtd_disponivel'),
            'interessados' => $this->json('interessados')
        ]);
        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'peso' => 'required|integer',
            'qtd_disponivel' => 'required|min:1|integer',
            'interessados.*.email' => 'email'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Nome do bole é obrigatório.',
            'peso.required' => 'Peso do bolo é obrigatório.',
            'peso.integer' => 'Peso deve ser um número inteiro.',
            'qtd_disponivel.required' => 'A quantidade disponivel é obrigatória.',
            'qtd_disponivel.min' => 'A quantidade disponivel deve ser maior que :min.',
            'interessados.*.email' => 'Insira um email valido.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'nook',
                'msg' => 'Verifique os campos.',
                'errors' => $validator->getMessageBag()->all()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
