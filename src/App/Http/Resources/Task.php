<?php

namespace Yahyya\taskmanager\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class Task extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'description'=>$this->desc,
            'labels'=>new \Yahyya\taskmanager\App\Http\Resources\LabelCollection($this->labels)
        ];
    }
}
