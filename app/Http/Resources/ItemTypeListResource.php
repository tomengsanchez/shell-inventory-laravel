<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ItemTypeListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        JsonResource::withoutWrapping();
        return parent::toArray($request);

        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'new_item' => $this->email
        // ];
    }
}
