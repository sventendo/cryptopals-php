<?php declare(strict_types=1);

namespace Sventendo\Cryptopals\Service;

use Sventendo\Cryptopals\Exceptions\InvalidHexValueException;
use Sventendo\Cryptopals\Exceptions\InvalidLetterException;
use Sventendo\Cryptopals\Exceptions\InvalidStringLengthException;
use Sventendo\Cryptopals\ValueTypes\HexDouble;

class ConversionService
{
    const VALID_CHARACTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/\ !?;,.-_()[]{}\'"';
    /**
     * @var string
     */
    private $hexMap = '0123456789abcdef';
    /**
     * @var string
     */
    private $base64Map = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

    public function base64Character(int $value): string
    {
        return $this->base64Map[$value];
    }

    public function decToHexDouble(int $value): HexDouble
    {
        if ($value > 255) {
            throw new InvalidHexValueException($value . ' is not a valid double hex value.');
        }

        return new HexDouble($this->decToHex((int)floor($value / 16)) . $this->decToHex($value % 16));
    }

    public function decToHex(int $value): string
    {
        if ($value >= strlen($this->hexMap)) {
            throw new InvalidHexValueException($value . ' is not a valid hex value.');
        }

        return $this->hexMap[$value];
    }

    public function hexDoubleStringToAscii(string $input)
    {
        if (strlen($input) % 2 !== 0) {
            throw new InvalidStringLengthException('Input length must be a multiple of 2.');
        }

        $output = '';

        foreach (str_split($input, 2) as $hexDouble) {
            $output .= $this->hexDoubleToAscii($hexDouble);
        }

        return $output;
    }

    public function hexDoubleToAscii(HexDouble $input)
    {
        return chr($this->hexDoubleToDec($input));
    }

    public function hexDoubleToDec(HexDouble $input): int
    {
        return $this->hexToDec($input->getCharacter(0)) * 16 + $this->hexToDec($input->getCharacter(1));
    }

    public function hexToDec(string $character): int {
        return strpos($this->hexMap, strtolower($character));
    }

    public function sanitizeHexDouble(HexDouble $hexDouble): void
    {
        $letter = $this->hexDoubleToAscii($hexDouble);
        if (!strpos(self::VALID_CHARACTERS, $letter) && $letter !== PHP_EOL) {
            throw new InvalidLetterException('Letter "' . $letter . '" is not in the list of valid letters.');
        }
    }
}
