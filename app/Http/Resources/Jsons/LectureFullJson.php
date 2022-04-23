<?php

namespace App\Http\Resources\Jsons;

use App\Models\Student;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use JsonSerializable;

class LectureFullJson extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $classrooms = $this->classrooms;
        $students = null;
        if($classrooms->count()>0) {
            $students = Student::whereIn('classroom_id', $classrooms->pluck('id'))->get();
        }
        return [
            'id'=>$this->id,
            'theme'=>$this->theme,
            'description'=>$this->description,
            'classrooms'=>$classrooms?ClassroomJson::collection($classrooms)->toArray($request):[],
            'students'=>$students?StudentJson::collection($students)->toArray($request):[],
            'created_at'=>$this->created_at?Carbon::make($this->created_at)->format('d.m.Y'):null,
        ];
    }
}
