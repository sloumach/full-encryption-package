<?php

namespace FullEncryption\Facades;

use Illuminate\Support\Facades\Facade;

class Encrypted extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \FullEncryption\FullEncryptionService::class;
    }
}
