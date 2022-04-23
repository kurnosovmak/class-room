<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Traits\Sortable;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Classroom
 *
 * @property int $id
 * @property string $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom query()
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lecture[] $lectures
 * @property-read int|null $lectures_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students
 * @property-read int|null $students_count
 * @method static Builder|Classroom filter(\App\Http\Filters\QueryFilter $filter)
 * @method static Builder|Classroom search(string $text)
 * @method static Builder|Classroom sort()
 */
class Classroom extends Model
{
    use HasFactory, Sortable, Filterable;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function (Classroom $model) {
            $model->lectures()->detach();
            $model->students()->update(['classroom_id' => null]);
        });
    }


    public function lectures(): BelongsToMany
    {
        return $this->belongsToMany(Lecture::class,'classroom_lecture');

    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function scopeSearch(Builder $query, string $text): void
    {
        $query->where('title', 'LIKE', "%$text%");
    }

}
