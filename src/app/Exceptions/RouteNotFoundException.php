<?php

namespace App\Exceptions;

/**
 * @throws RouteNotFoundException
 */
class RouteNotFoundException extends \Exception
{
    protected $message = '404 Not Found';
}