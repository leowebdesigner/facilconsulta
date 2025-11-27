<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'document' => $this->document,
            'crm' => $this->crm,
            'specialty' => $this->specialty,
            'experience_years' => $this->experience_years,
            'bio' => $this->bio,
            'is_active' => (bool) $this->is_active,
            'schedules' => DoctorScheduleResource::collection(
                $this->whenLoaded('schedules')
            ),
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
