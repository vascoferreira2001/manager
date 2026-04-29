<?php

namespace App\Core\Http;

final class Response
{
    private int $status = 200;
    private array $headers = [];

    public function status(int $code): self
    {
        $this->status = $code;
        return $this;
    }

    public function header(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function json(array $data, int $status = 200): void
    {
        $this->status($status)->header('Content-Type', 'application/json; charset=utf-8');
        $this->sendHeaders();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function text(string $content, int $status = 200): void
    {
        $this->status($status)->header('Content-Type', 'text/plain; charset=utf-8');
        $this->sendHeaders();
        echo $content;
    }

    public function html(string $content, int $status = 200): void
    {
        $this->status($status)->header('Content-Type', 'text/html; charset=utf-8');
        $this->sendHeaders();
        echo $content;
    }

    public function redirect(string $to, int $status = 302): void
    {
        $this->status($status)->header('Location', $to);
        $this->sendHeaders();
    }

    private function sendHeaders(): void
    {
        http_response_code($this->status);
        foreach ($this->headers as $k => $v) {
            header("{$k}: {$v}");
        }
    }
}