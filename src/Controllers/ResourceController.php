<?php

namespace Sdkconsultoria\Core\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sdkconsultoria\Core\Controllers\Traits\ApiControllerTrait;
use Sdkconsultoria\Core\Controllers\Traits\ResourceControllerTrait;

class ResourceController extends Controller
{
    use ApiControllerTrait;
    use ResourceControllerTrait;

    protected $model = '';
    protected $view = 'base::back.default';
}
