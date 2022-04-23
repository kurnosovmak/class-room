<?php


namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class StudentFilter extends QueryFilter
{

    /**
     * @param string $text
     */
    public function search(string $text): void
    {
        $this->builder->search($text);
    }

    /**
     * @param int $classroom_id
     */
    public function classroom(int $classroom_id): void
    {
        $this->builder->whereClassroomId($classroom_id);
    }
}
