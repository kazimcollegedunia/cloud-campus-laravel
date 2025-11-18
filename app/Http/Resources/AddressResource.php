<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
           // 'id'          => $this->id,
            'address_line'=> $this->address_line,
            'city'        => $this->city,
            'state'       => $this->state,
            'country'     => $this->country,
            'pincode'     => $this->pincode,
        ];
    }
}
