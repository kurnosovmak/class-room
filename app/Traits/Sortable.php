<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    public function scopeSort(Builder $query): void
    {
        $query->orderBy('created_at','DESC');
    }
}
