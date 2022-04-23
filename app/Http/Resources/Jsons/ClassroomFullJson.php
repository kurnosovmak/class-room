<?php

namespace App\Http\Resources\Jsons;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use JsonSerializable;

class ClassroomFullJson extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $students = $this->students;

        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'students'=>$students?StudentJson::collection($students)->toArray($request):[],
            'created_at'=>$this->created_at?Carbon::make($this->created_at)->format('d.m.Y'):null,
        ];
    }
}
