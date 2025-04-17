<?php

namespace Core;

class Request{
    private array $data;
    private array $server;

    public function __construct(array $data, array $server){
        $this->data = $data;
        $this->server = $server;
    }

    public function get(string $key): ?string{
        return $this->data[$key] ?? null;
    }

    public function getIp(): string{
        return $this->server['REMOTE_ADDR'] ?? "unknown";
    }
}