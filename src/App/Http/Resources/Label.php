<?php

namespace Yahyya\taskmanager\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class Label extends JsonResource
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
            'label'=>$this->title,
            'totalTasks'=>$this->tasks()->where('user_id',Auth::user()->id)->count()
        ];
    }
}
