<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorScheduleResource extends JsonResource
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
            'weekday' => $this->weekday,
            'start_time' => optional($this->start_time)->format('H:i'),
            'end_time' => optional($this->end_time)->format('H:i'),
            'slot_duration' => $this->slot_duration,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
