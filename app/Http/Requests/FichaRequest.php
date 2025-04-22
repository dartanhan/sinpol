<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FichaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Permitir requisição de qualquer usuário
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Dados pessoais
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'email' => 'required|email|max:255',
            'nacionalidade' => 'required|string|max:100',
            'naturalidade' => 'required|string|max:100',
            'sexo' => 'required|in:Feminino,Masculino,Outros',
            'data_nascimento' => 'required|date',
            'estado_civil' => 'required|string|max:50',
            'telefone' => 'required|string|max:20',

            // Endereço
            'cep' => 'required|string|max:9',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:100',
            'municipio' => 'required|string|max:100',
            'estado' => 'required|string|max:2',

            // Identificação
            'filiacao' => 'required|string|max:255',
            'identidade' => 'required|string|max:20',
            'orgao_emissor' => 'required|string|max:20',

            // Funcionais
            'cargo' => 'required|string|max:100',
            'data_admissao' => 'required|date',
            'lotacao' => 'required|string|max:150',
            'matricula' => 'required|string|max:50',
            'id_funcional' => 'required|string|max:50',
            'aposentado' => 'required|in:Sim,Não',
            'data_aposentadoria' => 'nullable|date',

            // Beneficiários
            'beneficiarios' => 'nullable|array',
            'beneficiarios.*' => 'in:conjuge,filho',

            // Arquivos
            'arquivos' => 'required|array|min:1',
            'arquivos.*' => 'file|max:5120',

            // reCAPTCHA
            'g-recaptcha-response' => 'required|captcha',
            'autorizacao_desconto' => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'cpf.digits' => 'O CPF deve conter exatamente 11 dígitos.',
            'cep.digits' => 'O CEP deve conter 8 dígitos.',
            'arquivos.*.max' => 'Cada arquivo pode ter no máximo 5MB.',
            'g-recaptcha-response.required' => 'Por favor, confirme que você não é um robô.',
            'g-recaptcha-response.captcha' => 'Falha na verificação do reCAPTCHA.'
        ];
    }
}
