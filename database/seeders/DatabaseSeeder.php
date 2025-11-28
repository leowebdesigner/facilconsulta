<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $patients = Patient::factory()->count(10)->create();
        $doctors = Doctor::factory()->count(5)->create();
        $scheduleTemplates = collect([
            ['weekday' => 1, 'start_time' => '09:00', 'end_time' => '12:00'],
            ['weekday' => 2, 'start_time' => '13:00', 'end_time' => '17:00'],
            ['weekday' => 3, 'start_time' => '08:00', 'end_time' => '11:00'],
            ['weekday' => 4, 'start_time' => '10:00', 'end_time' => '14:00'],
            ['weekday' => 5, 'start_time' => '15:00', 'end_time' => '18:00'],
        ]);

        $doctors->each(function (Doctor $doctor) use ($patients, $scheduleTemplates) {
            $schedules = $scheduleTemplates
                ->shuffle()
                ->take(3)
                ->map(fn (array $slot) => DoctorSchedule::factory()->create(array_merge($slot, [
                    'doctor_id' => $doctor->id,
                ])));

            Appointment::factory()->count(3)->create([
                'patient_id' => fn () => $patients->random()->id,
                'doctor_id' => $doctor->id,
                'doctor_schedule_id' => fn () => $schedules->random()->id,
            ]);
        });
    }
}
