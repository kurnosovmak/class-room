<?php


namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class LectureFilter extends QueryFilter
{

    /**
     * @param string $text
     */
    public function search(string $text): void
    {
        $this->builder->search($text);
    }
}
