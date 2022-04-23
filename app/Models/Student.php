<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use App\Traits\Sortable;

/**
 * App\Models\Student
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $classroom_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereClassroomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Student sort()
 * @method static Builder|Student filter(\App\Http\Filters\QueryFilter $filter)
 * @method static Builder|Student search(string $text)
 * @property-read \App\Models\Classroom|null $classroom
 */
class Student extends Model
{
    use HasFactory, Sortable, Filterable;

    protected $guarded = ['id'];

    public function scopeSearch(Builder $query,string $text): void
    {
        $query->where(function (Builder $query) use ($text) {
            $query->where('name','LIKE',"%$text%");
            $query->orWhere('email','LIKE',"%$text%");
        });
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

}
