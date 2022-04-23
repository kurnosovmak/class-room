<?php

namespace App\Http\Resources\Jsons;

use App\Models\Student;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use JsonSerializable;

class LectureJson extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id'=>$this->id,
            'theme'=>$this->theme,
            'description'=>$this->description,
            'created_at'=>$this->created_at?Carbon::make($this->created_at)->format('d.m.Y'):null,
        ];
    }
}
