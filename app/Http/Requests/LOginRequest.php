<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette demande.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'status_code' => 422, // Utilisez 422 pour les erreurs de validation
            'error' => true,
            'message' => 'Erreur de validation',
            'errorslist' => $validator->errors(),
        ], 422));
    }

    public function messages()
    {
        return [
            'email.required' => 'Email non fourni',
            'email.email' => 'Adresse email non valide',
            'email.exists' => 'Email inexistant',
            'password.required' => 'Le mot de passe n\'est pas fourni',
        ];
    }
}
