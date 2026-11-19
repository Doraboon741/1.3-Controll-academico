<?php

namespace Database\Seeders;

use App\Models\AcademicRecord;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Cuenta del profesor
        User::create([
            'name'     => 'Profe Kenneth',
            'email'    => 'profesor@utt.edu.mx',
            'password' => Hash::make('12345678'),
            'role'     => 'profesor',
        ]);

        // Cuentas de los estudiantes
        $alumnos = [
            ['name' => 'Gabo Santana', 'email' => 'gabo@utt.edu.mx', 'absences' => 1, 'grade' => 9.8],
            ['name' => 'Mia Gurza', 'email' => 'mia@utt.edu.mx', 'absences' => 3, 'grade' => 8.7],
            ['name' => 'Jesus Aranda', 'email' => 'aranda@utt.edu.mx', 'absences' => 0, 'grade' => 7.6],
            ['name' => 'Fatima Coronado', 'email' => 'fatima@utt.edu.mx', 'absences' => 6, 'grade' => 6.4],
        ];

        foreach ($alumnos as $data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('12345678'),
                'role'     => 'alumno',
            ]);

            AcademicRecord::create([
                'user_id'  => $user->id,
                'absences' => $data['absences'],
                'grade'    => $data['grade'],
            ]);
        }
    }
}