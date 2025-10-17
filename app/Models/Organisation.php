<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Organisation
 *
 * @property int $id
 * @property string $title
 * @property int $building_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $phones
 *
 * @package App\Models
 */
class Organisation extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;

    protected $table = 'organisation';

    protected $fillable = ['title', 'phones'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'phones' => 'array',
    ];

    public static array $sortColumns = [
        'id',
        'title',
        'created_at'
    ];

    public static array $relationships = [
        'buildings',
        'business'
    ];

    public function buildings(): BelongsTo
    {
        return $this->belongsTo(
            Building::class,
            'id',
            'building_id',
            'building'
        );
    }

    public function business(): BelongsToMany
    {
        return $this->belongsToMany(
            Business::class,
            'organisation_business',
            'organisation_id',
            'business_id',
        );
    }
}
