<?php

namespace FullEncryption\Facades;

use Illuminate\Support\Facades\Facade;

class FullEncrypted extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \FullEncryption\FullEncryptionService::class;
    }
}
