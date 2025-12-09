<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'name' => $this->name,
            // 'email' => $this->email,
            // 'department' => new DepartmentResource($this->whenLoaded('department')),
            // 'contacts' => ContactResource::collection($this->whenLoaded('contactNumbers')),
            // 'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
            // 'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
