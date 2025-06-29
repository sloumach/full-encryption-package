<?php

namespace FullEncryption;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\User;

class FullEncryptionService
{
    /**
     * Encrypt a message using the user's unique key.
     */
    public function fullEncrypt(string $plaintext, User $user): string
    {
        $key = $this->getUserKey($user);

        $output = '';
        for ($i = 0; $i < strlen($plaintext); $i++) {
            $output .= chr(ord($plaintext[$i]) ^ ord($key[$i % strlen($key)]));
        }

        return base64_encode($output);
    }

    /**
     * Decrypt a message using the user's unique key.
     */
    public function fullDecrypt(string $ciphertext, User $user): string
    {
        $key = $this->getUserKey($user);

        $cipher = base64_decode($ciphertext);
        $output = '';
        for ($i = 0; $i < strlen($cipher); $i++) {
            $output .= chr(ord($cipher[$i]) ^ ord($key[$i % strlen($key)]));
        }

        return $output;
    }

    /**
     * Get or generate the user's encryption key.
     */
    private function getUserKey(User $user): string
    {
        if (empty($user->enckey)) {
            $rawKey = substr(hash('sha256', strtolower($user->email)), 0, 32);
            $user->enckey = Crypt::encrypt($rawKey);
            $user->save();
        }

        return Crypt::decrypt($user->enckey);
    }
}
