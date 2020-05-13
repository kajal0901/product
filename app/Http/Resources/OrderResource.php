<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Resource for product model.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'p_id' => $this->p_id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'delivery_address' => $this->delivery_address,
            'delivery_city' => $this->delivery_city,
            'delivery_postcode' => $this->delivery_postcode,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
