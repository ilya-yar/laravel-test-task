<?php

namespace App\Http\Filters;

interface SearchAreaEnum
{
    const NONE = 0;
    const CIRCLE = 1;
    const RECTANGLE = 2;
    const RECTANGLE_BY_POINT = 3;
}
