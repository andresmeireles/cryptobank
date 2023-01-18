<?php

declare(strict_types=1);

namespace Cryptocli\Errors;

interface Error
{
    public function message(): string;
}
