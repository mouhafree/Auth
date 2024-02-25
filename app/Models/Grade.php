<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'note'];

    // Définir la relation avec la table des étudiants
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
