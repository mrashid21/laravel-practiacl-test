<?php

namespace App\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InputResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!$this->resource) {
            return [];
        }

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'attributes' => $this->attributes,
        ];

        return $data;
    }

}