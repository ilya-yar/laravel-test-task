<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Building
 *
 * @property int $id
 * @property string $address
 * @property float $latitude
 * @property float $longitude
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Building extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;

    protected $table = 'building';

    protected $fillable = ['address', 'latitude', 'longitude'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public static array $sortColumns = [
        'id',
        'address',
        'created_at'
    ];

    public static array $relationships = [
        'organisations',
    ];

    public function organisations()
    {
        return $this->hasMany(Organisation::class);
    }
}
