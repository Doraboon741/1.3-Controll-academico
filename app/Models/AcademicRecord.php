<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicRecord extends Model
{
    protected $fillable = [
        'user_id',
        'absences',
        'grade',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Aqui se calcula lo de las calis, la equivalencia
    protected function equivalence(): Attribute
    {
        return Attribute::get(function () {
            $grade = (float) $this->grade;

            return match (true) {
                $grade >= 9.5 => 'AU', // Autonomo
                $grade >= 8.5 => 'DE', // Destacado
                $grade >= 7.5 => 'SA', // Suficiente
                default       => 'NA', // No acreditado
            };
        });
    }
}