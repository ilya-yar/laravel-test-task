<?php

namespace App\Http\Filters;

use App\Models\Organisation;
use Illuminate\Support\Facades\DB;

class OrganisationFilter extends QueryFilter
{
    use Sortable;
    use Searchable;

    protected function &sortColumns(): array
    {
        return Organisation::$sortColumns;
    }

    public function title(string $title): void
    {
        $this->builder->where('title', $title);
    }

    public function buildings(string $buildings): void
    {
        $buildings = explode(',', $buildings);
        $this->builder->whereIn('building_id', $buildings);
    }

    public function business(string $business): void
    {
        $businessArr = DB::select('WITH RECURSIVE subbusiness AS (
    -- Нерекурсивная часть: находим деятельность и задаём начальный уровень 1
    SELECT
        id,
        1 AS level
    FROM business
    WHERE id in (:id)

    UNION ALL

    -- Рекурсивная часть: находим дочерние элементы, пока уровень не превышает 3
    SELECT
        e.id,
        s.level + 1
    FROM business e
             JOIN subbusiness s ON e.parent_id = s.id
    WHERE s.level < :level -- Ограничение по глубине
)
SELECT distinct id FROM subbusiness;', ['id' => $business, 'level' => 3]);
        $businessArr = array_column($businessArr, 'id');
        $this->builder->whereHas('business', function ($builder) use ($businessArr) {
            $builder->whereIn('business.id', $businessArr);
        });
    }

    public function with(string $with): void
    {
        $relations = explode(',', $with);
        foreach ($relations as $relation) {
            if (in_array($relation, Organisation::$relationships))
                $this->builder->with($relation);
        }
    }

    private function addCoordinates(): void
    {
        $this->builder
            ->leftJoin('building', 'organisation.building_id', '=', 'building.id')
            ->addSelect('organisation.*', 'building.latitude', 'building.longitude');
    }

    protected function afterApply(): void
    {
        if ($this->searchLogic()) {
            $this->addCoordinates();
            $this->search();
            $this->addSortColumn('distance');
        }
    }
}
