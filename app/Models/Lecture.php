<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use App\Traits\Sortable;

/**
 * App\Models\Lecture
 *
 * @property int $id
 * @property string $theme
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Lecture filter(\App\Http\Filters\QueryFilter $filter)
 * @method static Builder|Lecture search(string $text)
 * @method static Builder|Lecture sort()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Classroom[] $classrooms
 * @property-read int|null $classrooms_count
 */
class Lecture extends Model
{
    use HasFactory, Filterable, Sortable;

    protected array $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function (Lecture $model) {
            $model->classrooms()->detach();
        });
    }

    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class);
    }


    public function scopeSearch(Builder $query, string $text): void
    {
        $query->where(function (Builder $builder) use ($text) {
            $builder->where('theme', 'LIKE', "%$text%");
            $builder->orWhere('description', 'LIKE', "%$text%");
        });
    }
}
