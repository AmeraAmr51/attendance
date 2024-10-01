<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'check_in' => $this->clock_in,
            'check_out' => $this->clock_out,
            'total_hours' => $this->total_hours,
            'location_type' => $this->location_type,
            'shift_name' => $this->shift?->name,
        ];
    }
}
