<?php

namespace Sventendo\Cryptopals\ValueTypes;

class Hex
{
    public const VALID_CHARACTERS = '0123456789abcdef';

    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
