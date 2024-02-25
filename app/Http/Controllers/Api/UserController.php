<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\LOginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function register(RegisterRequest $request){
        try {
            // Créez une nouvelle instance d'utilisateur
            $user = new User();
    
            // Définissez les propriétés de l'utilisateur
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
    
            // Enregistrez l'utilisateur
            $user->save();
    
            // Retournez une réponse JSON
            return response()->json([
                'message' => 'Inscription réussie !!',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

   


    
    public function login(LoginRequest $request)
    {
        try {
            // Tentative d'authentification de l'utilisateur
            $credentials = $request->only('email', 'password');
    
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
    
                // Génération d'un jeton d'accès pour l'utilisateur authentifié
                $token = $user->createToken('authToken')->plainTextToken;
    
                return response()->json([
                    'message' => 'Connexion réussie',
                    'user' => $user,
                    'access_token' => $token,
                ], 200);
            } else {
                // Si l'authentification échoue, retournez une réponse JSON
                return response()->json([
                    'message' => 'Échec de l\'authentification. Veuillez vérifier vos identifiants.',
                ], 401);
            }
        } catch (\Exception $e) {
            // Gestion des exceptions
            return response()->json([
                'message' => 'Erreur lors de la tentative de connexion',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
 
public function logout(Request $request)
{
    try {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user has an access token
            if ($user->currentAccessToken()) {
                // Revoke the current access token
                $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            }

            return response()->json([
                'status_code' => 200,
                'message' => 'Déconnexion réussie',
                
            ]);
        } else {
            return response()->json([
                'status_code' => 401,
                'message' => 'Utilisateur non authentifié',
            ], 401);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status_code' => 500,
            'message' => 'Erreur lors de la déconnexion',
            'error' => $e->getMessage(),
        ]);
    }
}
// public function logout(Request $request){
//     $accesToken = $request->bearerToken();
//     $token = User::findToken($accesToken);
//     $token-> delete();

//     return response()->json([
//         'status' =>true,
//         'message' => 'Deconnexion valide'
       
//     ]);
// }

// public function logout(Request $request)
// {
//     try {
//         $user = Auth::user();

//         if ($user) {
//             $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

//             return response()->json([
//                 'status' => true,
//                 'message' => 'Déconnexion réussie',
//             ]);
//         } else {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Utilisateur non authentifié',
//             ], 401); // Utilisateur non autorisé
//         }
//     } catch (\Exception $e) {
//         \Log::error($e);

//         return response()->json(['message' => 'Erreur lors de la déconnexion'], 500);
//     }
// }

}