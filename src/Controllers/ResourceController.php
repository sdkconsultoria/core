<?php

namespace Sdkconsultoria\Core\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sdkconsultoria\Core\Controllers\SimpleResourceController;
use Sdkconsultoria\Core\Controllers\Traits\ApiControllerTrait;

class ResourceController extends SimpleResourceController
{
    use ApiControllerTrait;
}
