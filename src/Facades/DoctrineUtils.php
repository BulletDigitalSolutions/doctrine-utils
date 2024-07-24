<?php

namespace Bullet\DoctrineUtils\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bullet\DoctrineUtils\DoctrineUtils
 */
class DoctrineUtils extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Bullet\DoctrineUtils\DoctrineUtils::class;
    }
}
