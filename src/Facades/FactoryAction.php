<?php

namespace CodeWithDennis\FactoryAction\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CodeWithDennis\FactoryAction\FactoryAction
 */
class FactoryAction extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \CodeWithDennis\FactoryAction\FactoryAction::class;
    }
}
