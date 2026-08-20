<?php

namespace Database\Seeders;

use App\Models\stp_career;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CareerSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            'Engineer' => [85, 90, 30, 35, 45, 65],
            'Scientist' => [45, 95, 30, 35, 25, 60],
            'Chef' => [85, 35, 85, 50, 55, 55],
            'Photographer' => [65, 40, 95, 45, 55, 35],
            'Paramedic' => [80, 70, 25, 90, 45, 60],
            'Physio' => [70, 75, 30, 95, 35, 55],
            'Pilot' => [90, 75, 30, 40, 70, 80],
            'Farmer' => [95, 55, 30, 35, 70, 55],
            'Technician' => [95, 70, 25, 30, 40, 90],
            'Mechanic' => [95, 65, 25, 30, 40, 90],
            'Programmer' => [50, 95, 55, 30, 35, 90],
            'Architect' => [75, 85, 95, 40, 60, 65],
            'Doctor' => [45, 95, 25, 90, 55, 70],
            'Psychologist' => [25, 90, 55, 95, 45, 55],
            'Economist' => [25, 95, 35, 55, 85, 80],
            'Consultant' => [30, 85, 45, 75, 90, 65],
            'Pharmacist' => [45, 90, 25, 70, 45, 95],
            'Statistician' => [25, 100, 25, 35, 30, 95],
            'Teacher' => [30, 65, 70, 95, 60, 55],
            'Therapist' => [35, 75, 65, 95, 35, 50],
            'Publicist' => [25, 55, 90, 80, 95, 50],
            'Producer' => [45, 60, 90, 70, 95, 65],
            'Animator' => [55, 70, 95, 30, 40, 80],
            'Editor' => [25, 75, 95, 45, 45, 90],
            'Lawyer' => [25, 85, 55, 85, 95, 75],
            'Diplomat' => [25, 75, 55, 95, 95, 65],
            'Nurse' => [55, 70, 25, 95, 40, 90],
            'Librarian' => [30, 70, 55, 85, 45, 95],
            'Manager' => [35, 65, 40, 80, 95, 90],
            'Accountant' => [25, 75, 25, 45, 80, 100],
        ];

        foreach ($profiles as $name => [$r, $i, $a, $s, $e, $c]) {
            stp_career::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'realistic' => $r,
                    'investigative' => $i,
                    'artistic' => $a,
                    'social' => $s,
                    'enterprising' => $e,
                    'conventional' => $c,
                    'status' => 1,
                ]
            );
        }
    }
}
