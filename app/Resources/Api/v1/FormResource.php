<?php

namespace App\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\Api\v1\InputResource;

class FormResource extends JsonResource {

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
            'title' => $this->title,
            'description' => $this->description,
            'created_by' => $this->createdBy->name,
            'input_fields' => InputResource::collection($this->inputs),
        ];

        return $data;
    }

}