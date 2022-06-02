<?php

namespace Sdkconsultoria\Core\Tests;

use Illuminate\Support\Facades\Artisan;

class MakeUserTest extends TestCase
{
    public function test_make_default()
    {
        Artisan::call('sdk:user');
    }
}
