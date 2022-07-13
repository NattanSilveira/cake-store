<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CakeUpdateRequest extends FormRequest
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
            'qtd_disponivel' => $this->json('qtd_disponivel')
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
            'nome' => 'nullable',
            'peso' => 'nullable|integer',
            'qtd_disponivel' => 'nullable|min:1|integer',
        ];
    }

    public function messages()
    {
        return [
            'peso.integer' => 'Peso deve ser um número inteiro.',
            'qtd_disponivel.min' => 'A quantidade disponivel deve ser maior que :min.',
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
