<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotebookResource extends JsonResource
{
    //TODO: Deeper dive here to customize
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'title' => $this['title'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at']
        ];
    }
}
