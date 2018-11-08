<?php

namespace Sventendo\Cryptopals\ValueTypes;

use Sventendo\Cryptopals\Exceptions\InvalidLetterException;
use Sventendo\Cryptopals\Exceptions\InvalidStringLengthException;

class HexDouble extends Hex
{
    public function __construct(string $value)
    {
        if (strlen($value) !== 2) {
            throw new InvalidStringLengthException('HexDouble must consist of 2 characters.');
        }

        if (strpos(self::VALID_CHARACTERS, (string)$value[0]) === false) {
            throw new InvalidLetterException($value[0] . ' is not a valid character.');
        }

        if (strpos(self::VALID_CHARACTERS, (string)$value[1]) === false) {
            throw new InvalidLetterException($value[1] . ' is not a valid character.');
        }

        parent::__construct($value);
    }

    public function getCharacter(int $int)
    {
        return $this->value[$int];
    }
}
