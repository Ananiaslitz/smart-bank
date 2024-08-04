<?php

namespace Core\Infrastructure\Exceptions;

class GatewayException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Gateway Error - 30% limit', 401);
    }
}
