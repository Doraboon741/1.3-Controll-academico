<?php

namespace App\Http\Controllers;

use App\Models\AcademicRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AcademicController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Si es alumno solo consulta su propia información
        if ($user->role === 'alumno') {
            $records = AcademicRecord::with('student')
                ->where('user_id', $user->id)
                ->get();

            return view('academic.index', [
                'records'   => $records,
                'sort'      => 'name',
                'direction' => 'asc',
            ]);
        }

        // Si es profesor, puede ordenar por nombre, calificación o faltas
        $sort      = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc') === 'desc' ? 'desc' : 'asc';

        $query = AcademicRecord::query()
            ->join('users', 'academic_records.user_id', '=', 'users.id')
            ->select('academic_records.*')
            ->with('student');

        match ($sort) {
            'grade'    => $query->orderBy('academic_records.grade', $direction),
            'absences' => $query->orderBy('academic_records.absences', $direction),
            default    => $query->orderBy('users.name', $direction),
        };

        return view('academic.index', [
            'records'   => $query->get(),
            'sort'      => $sort,
            'direction' => $direction,
        ]);
    }

    public function create()
    {
        return view('academic.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'absences' => 'required|integer|min:0|max:100',
            'grade'    => 'required|numeric|min:0|max:10',
        ]);

        DB::transaction(function () use ($validated) {
            $student = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'alumno',
            ]);

            AcademicRecord::create([
                'user_id'  => $student->id,
                'absences' => $validated['absences'],
                'grade'    => $validated['grade'],
            ]);
        });

        return redirect()->route('academic.index')
            ->with('success', 'Alumno registrado correctamente.');
    }

    public function edit(AcademicRecord $record)
    {
        $record->load('student');
        return view('academic.edit', compact('record'));
    }

    public function update(Request $request, AcademicRecord $record)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($record->user_id)],
            'absences' => 'required|integer|min:0|max:100',
            'grade'    => 'required|numeric|min:0|max:10',
        ]);

        DB::transaction(function () use ($validated, $record) {
            $record->student->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            $record->update([
                'absences' => $validated['absences'],
                'grade'    => $validated['grade'],
            ]);
        });

        return redirect()->route('academic.index')
            ->with('success', 'Información académica actualizada.');
    }

    public function destroy(AcademicRecord $record)
    {
        // Al eliminar el alumno el cascadeOnDelete elimina también su registro académico
        $record->student->delete();

        return redirect()->route('academic.index')
            ->with('success', 'Alumno eliminado del sistema.');
    }
}