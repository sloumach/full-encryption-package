<?php

namespace FullEncryption\Traits;

use FullEncryption\FullEncryptionService;

trait Encryptable
{
    /**
     * Encrypt du texte avec la clé unique de l'utilisateur.
     */
    public function fullEncrypt(string $text): string
    {
        return app(FullEncryptionService::class)->fullEncrypt($text, $this);
    }

    /**
     * Décrypte un texte chiffré avec la clé de l'utilisateur.
     */
    public function fullDecrypt(string $ciphertext): string
    {
        return app(FullEncryptionService::class)->fullDecrypt($ciphertext, $this);
    }
}
