<?php

namespace Bigsnowfr\Larastats;

use \Illuminate\Support\Facades\Facade;

class LarastatsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'larastats';
    }
}