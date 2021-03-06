<?php

namespace Sdkconsultoria\Core\Controllers\Traits;

use Illuminate\Http\Request;

trait PaginationTrait
{
    protected $pagination = 15;

    protected function setPagination($query, Request $request)
    {
        $pages = $this->getElementsPerPage($request);

        return $query->paginate($pages)->appends($request->all());
    }

    protected function getElementsPerPage(Request $request)
    {
        return $request->pagination ?? $this->pagination;
    }
}
