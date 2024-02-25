<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
public function students(StudentRequest $request){
    try {
        // Créez une nouvelle instance d'utilisateur
        $user = new Student();

        $user->name = $request->name;
        $user->course = $request->course;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Enregistrez l'utilisateur
        $user->save();

        // Retournez une réponse JSON
        return response()->json([
            'message' => 'Ajout d\'étudiant réussie !!',
            'user' => $user
        ], 201);
    } catch (\Exception $e) {
        return response()->json($e);
    }
}

public function getStudents()
{
    try {
        // Récupérez tous les étudiants de la base de données
        $students = Student::all();

        // Retournez une réponse JSON avec la liste des étudiants
        return response()->json([
            'success' => true,
            'message' => 'Liste des étudiants récupérée avec succès',
            'students' => $students
        ], 200);
    } catch (\Exception $e) {
        // En cas d'erreur, retournez une réponse JSON avec le message d'erreur
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la récupération des étudiants',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function addNoteStudent(Request $request, $identifiantEtudiant)
{
    try {
        Log::info("Identifiant étudiant reçu: $identifiantEtudiant");

        $etudiant = Student::find($identifiantEtudiant);

        if ($etudiant) {
            // Reste du code...
            return response()->json([
                'message' => 'ID retrouvee avec Suucess!',
                'user' => $etudiant
            ], 201);
        } else {
            // Ajoutez un message de log pour indiquer que l'étudiant n'a pas été trouvé
            Log::info("Étudiant non trouvé avec l'identifiant: $identifiantEtudiant");
            // Log::info("Requête SQL: " . Student::find($identifiantEtudiant)->toSql());

            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }
    } catch (\Exception $e) {
        Log::error("Erreur lors de la récupération de l'étudiant: " . $e->getMessage());
        return response()->json(['message' => 'Erreur lors de la récupération de l\'étudiant'], 500);
    }
}


public function addNoteStudents(Request $request, $identifiantEtudiant)
{
    try {
        // Recherchez l'étudiant dans la base de données par identifiant
        $etudiant = Student::find($identifiantEtudiant);

        // Vérifiez si l'étudiant a été trouvé
        if (!$etudiant) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        // Validation de la requête
        $validator = Validator::make($request->all(), [
            'note' => 'required|numeric|min:0|max:20', // Validation de la note
        ]);

        // Vérification des erreurs de validation
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Création de la note si la validation réussit
        $grade = new Grade();
        $grade->student_id = $etudiant->id;
        $grade->note = $request->input('note');
        $grade->save();

        return response()->json(['message' => 'Note ajoutée avec succès'], 200);
    } catch (\Exception $e) {
        // En cas d'erreur, retournez un message d'erreur
        Log::error("Erreur lors de l'ajout de la note: " . $e->getMessage());
        return response()->json(['message' => 'Erreur lors de l\'ajout de la note'], 500);
    }
}
// --------------------notes------------------
public function getAllNotes(): JsonResponse
{
    try {
        // Récupérez toutes les notes de la base de données
        $notes = Grade::all();

        // Retournez une réponse JSON avec la liste des notes
        return response()->json([
            'success' => true,
            'message' => 'Liste de toutes les notes récupérée avec succès',
            'notes' => $notes
        ], 200);
    } catch (\Exception $e) {
        // En cas d'erreur, retournez une réponse JSON avec le message d'erreur
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la récupération des notes',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function getNotes($identifiantEtudiant)
{
    try {
        // Recherchez l'étudiant dans la base de données par identifiant
        $etudiant = Student::find($identifiantEtudiant);

        // Vérifiez si l'étudiant a été trouvé
        if (!$etudiant) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        // Récupérez les notes de l'étudiant
        $notes = Grade::where('student_id', $etudiant->id)->get();

        return response()->json(['notes' => $notes], 200);
    } catch (\Exception $e) {
        // En cas d'erreur, retournez un message d'erreur
        Log::error("Erreur lors de la récupération des notes: " . $e->getMessage());
        return response()->json(['message' => 'Erreur lors de la récupération des notes'], 500);
    }
}

}





