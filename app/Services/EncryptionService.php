<?php
namespace App\Services;

class EncryptionService
{
    private string $key;

    public function __construct(string $appKey)
    {
        if (str_starts_with($appKey, 'base64:')) {
            $this->key = base64_decode(substr($appKey, 7));
        } else {
            $this->key = $appKey;
        }
    }

    public function encrypt(string $plaintext): array
    {
        $iv = random_bytes(16);
        $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext, $this->key, true);
        return [
            'enc' => $hmac . $ciphertext,
            'iv'  => $iv
        ];
    }

    public function decrypt(string $encWithHmac, string $iv): string|false
    {
        $hmac = substr($encWithHmac, 0, 32);
        $ciphertext = substr($encWithHmac, 32);
        $calculated = hash_hmac('sha256', $ciphertext, $this->key, true);
        if (!hash_equals($calculated, $hmac)) {
            return false;
        }
        return openssl_decrypt($ciphertext, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $iv);
    }

    public function hmacForSearch(string $normalized): string
    {
        return hash_hmac('sha256', $normalized, $this->key);
    }
}
