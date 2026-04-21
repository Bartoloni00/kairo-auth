<?php

namespace App\Modules\Auth\Application\Ports;

interface TokenProviderInterface
{
  public function generate(array $payload): string;
}
