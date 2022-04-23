<?php

namespace App\Http\Resources\Jsons;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use JsonSerializable;

class StudentFullJson extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $classroom = $this->classroom;
        $lectures = $classroom->lectures;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'classroom'=>$classroom?(new ClassroomJson($classroom)):null,
            'lectures'=>$classroom&&$lectures?(LectureJson::collection($lectures)->toArray($request)):[],
            'created_at'=>$this->created_at?Carbon::make($this->created_at)->format('d.m.Y'):null,
        ];
    }
}
