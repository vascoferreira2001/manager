<?php

namespace App\Core\Security;

final class Csrf
{
    private const KEY = '_csrf_token';

    public function __construct(private Session $session) {}

    public function token(): string
    {
        $token = $this->session->get(self::KEY);
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            $this->session->put(self::KEY, $token);
        }
        return $token;
    }

    public function validate(?string $token): bool
    {
        $stored = $this->session->get(self::KEY);
        return is_string($stored) && is_string($token) && hash_equals($stored, $token);
    }
}