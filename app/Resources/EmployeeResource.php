<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'department' => $this->whenLoaded('department') ? [
                'id' => $this->department->id,
                'name' => $this->department->name
            ] : null,
            'contact_numbers' => ContactNumberResource::collection($this->whenLoaded('contactNumbers')),
            'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
