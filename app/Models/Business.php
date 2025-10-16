<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Business
 *
 * @property int $id
 * @property string $title
 * @property int $parent_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Business extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;

    protected $table = 'business';

    protected $fillable = ['title'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public static array $sortColumns = [
        'id',
        'title',
        'created_at'
    ];

    public static array $relationships = [
        'subbusiness',
        'organisations',
    ];

    public function subbusiness(bool $recursive = true, bool $withCompanies = false)
    {
        $relation = $this->hasMany(Business::class, 'parent_id');

        if ($recursive) {
            if ($withCompanies)
                $relation->with('subbusiness.organisations');
            else
                $relation->with('subbusiness');
        } elseif ($withCompanies)
                $relation->with('organisations');

        return $relation;
    }

    public function organisations()
    {
        return $this->belongsToMany(Organisation::class);
    }
}
