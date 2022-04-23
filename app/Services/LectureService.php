<?php

namespace App\Services;

use App\Models\Classroom;
use App\Models\Lecture;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Throwable;

class LectureService
{
    protected Lecture $lectures;

    public function __construct(Lecture $lectures)
    {
        $this->lectures = $lectures;
    }


    /**
     * @param Classroom $classroom
     * @return Collection
     */
    public function getLecturesByClassroom(Classroom $classroom): Collection
    {
        $lectures_id_sort = $classroom->lectures()->newPivotQuery()->get(['lecture_id'])->pluck('lecture_id');
        return $this->lectures->whereIn('lectures.id', $lectures_id_sort)
            ->join('classroom_lecture', 'lectures.id', '=', 'classroom_lecture.lecture_id')
            ->orderBy('classroom_lecture.order')->get(['lectures.*']);
    }

    /**
     * @param Classroom $classroom
     * @param array $lectures_ids
     * @return Collection
     * @throws Throwable
     */
    public function setLecturesByClassroom(Classroom $classroom, array $lectures_ids): Collection
    {

        if (count($lectures_ids) <= 0) {
            $classroom->lectures()->detach();
            return collect();
        }

        DB::transaction(function () use ($lectures_ids, $classroom) {

            $classroom->lectures()->detach();

            foreach ($lectures_ids as $key => $id) {

                if ($this->existsLecture($key, $id, $classroom->id)) {
                    throw ValidationException::withMessages(["lectures.[$key]" => 'The lecture is already busy at this time OR lecture exists']);
                }
                $classroom->lectures()->attach($id, ['order' => $key]);
            }
        });
        return $this->getLecturesByClassroom($classroom);

    }

    /**
     * @param $order
     * @param $lecture_id
     * @param $classroom_id
     * @return bool
     */
    private function existsLecture(int $order, int $lecture_id, int $classroom_id): bool
    {
        $isExists = DB::table('classroom_lecture')->where(function ($query) use ($order, $lecture_id, $classroom_id) {
            $query->where('classroom_id', $classroom_id->id);
            $query->where('lecture_id', $lecture_id);
        })
            ->orWhere(function ($query) use ($order, $lecture_id) {
                $query->where('lecture_id', $lecture_id);
                $query->where('order', $order);
            })
            ->first();
        return $isExists ? true : false;
    }

}
