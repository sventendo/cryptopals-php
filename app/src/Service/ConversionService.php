<?php declare(strict_types=1);

namespace Sventendo\Cryptopals\Service;

use Sventendo\Cryptopals\Exceptions\InvalidHexValueException;
use Sventendo\Cryptopals\Exceptions\InvalidStringLengthException;

class ConversionService
{
    /**
     * @var string
     */
    private $hexMap = '0123456789abcdef';
    /**
     * @var string
     */
    private $base64Map = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

    public function hexToDec(string $character): int
    {
        return strpos($this->hexMap, strtolower($character));
    }

    public function decToHex(int $value): string
    {
        if ($value >= strlen($this->hexMap)) {
            throw new InvalidHexValueException($value . ' is not a valid hex value.');
        }

        return $this->hexMap[$value];
    }

    public function base64Character(int $value): string
    {
        return $this->base64Map[$value];
    }

    public function hexDoubleToDec(string $input): int
    {
        if (strlen($input) !== 2) {
            throw new InvalidStringLengthException('Input string length must be 2.');
        }

        return $this->hexToDec($input[0]) * 16 + $this->hexToDec($input[1]);
    }

    public function decToHexDouble(int $value): string
    {
        return $this->decToHex((int)floor($value / 16)) . $this->decToHex($value % 16);
    }

}
