<?php

namespace Bullet\DoctrineUtils\Interfaces;

interface UrlRoutable
{
    public static function resolveRouteBinding($value, $field = null);

    public static function getRouteKeyName(): string;
}
