<?php

namespace App\Http\Filters;

use App\Models\Organisation;

class OrganisationFilter extends QueryFilter
{
    use Sortable;
    use Searchable;

    protected function &sortColumns(): array
    {
        return Organisation::$sortColumns;
    }

    public function buildings(string $buildings): void
    {
        $buildings = explode(',', $buildings);
        $this->builder->whereIn('building_id', $buildings);
    }

    public function business(string $business): void
    {
        $businessArr = explode(',', $business);
        $this->builder->whereHas('business', function ($builder) use ($businessArr) {
            $builder->whereIn('business.id', $businessArr);
        });
        //$this->with('rubrics');
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
