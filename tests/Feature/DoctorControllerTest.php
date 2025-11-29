<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_doctors(): void
    {
        Doctor::factory()->count(2)->create();

        $response = $this->getJson('/api/v1/doctors');

        $response->assertOk()
            ->assertJsonStructure(['data' => ['doctors']]);
    }

    public function test_can_list_available_doctors(): void
    {
        $doctor = Doctor::factory()->create([
            'specialty' => 'Cardiology',
            'address' => 'Rua Teste, 100',
        ]);
        DoctorSchedule::factory()->create([
            'doctor_id' => $doctor->id,
            'weekday' => now()->dayOfWeekIso,
            'start_time' => '13:00',
            'end_time' => '15:00',
            'slot_duration' => 60,
        ]);

        $response = $this->getJson('/api/v1/doctors/available?date='.now()->toDateString().'&days=1');

        $response->assertOk()
            ->assertJsonCount(1, 'data.doctors')
            ->assertJsonPath('data.doctors.0.address', 'Rua Teste, 100')
            ->assertJsonPath('data.doctors.0.availability.0.slots', ['13:00', '14:00']);
    }
}
