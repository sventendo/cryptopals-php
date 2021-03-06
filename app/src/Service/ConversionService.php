<?php declare(strict_types=1);

namespace Sventendo\Cryptopals\Service;

use Sventendo\Cryptopals\Exceptions\InvalidHexValueException;
use Sventendo\Cryptopals\Exceptions\InvalidLetterException;
use Sventendo\Cryptopals\Exceptions\InvalidStringLengthException;
use Sventendo\Cryptopals\ValueTypes\HexDouble;

class ConversionService
{
    const VALID_CHARACTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789/\ !?;,.-_()[]\'"';
    /**
     * @var string
     */
    private $hexMap = '0123456789abcdef';
    /**
     * @var string
     */
    private $base64Map = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

    public function hexDoubleStringToAscii(string $input)
    {
        if (strlen($input) % 2 !== 0) {
            throw new InvalidStringLengthException('Input length must be a multiple of 2.');
        }

        $output = '';

        foreach (str_split($input, 2) as $hexDoubleValue) {
            $output .= $this->hexDoubleToAscii(new HexDouble($hexDoubleValue));
        }

        return $output;
    }

    public function hexDoubleToAscii(HexDouble $input)
    {
        $dec = $this->hexDoubleToDec($input);

        return chr($dec);
    }

    public function hexDoubleToDec(HexDouble $input): int
    {
        return $this->hexToDec($input->getCharacter(0)) * 16 + $this->hexToDec($input->getCharacter(1));
    }

    public function hexToDec(string $character): int
    {
        return strpos($this->hexMap, strtolower($character));
    }

    public function sanitizeHexDouble(HexDouble $hexDouble): void
    {
        $letter = $this->hexDoubleToAscii($hexDouble);
        if (!strpos(self::VALID_CHARACTERS, $letter) && $letter !== PHP_EOL) {
            throw new InvalidLetterException('Letter "' . $letter . '" is not in the list of valid letters.');
        }
    }

    public function hexToBase64(string $hex): string
    {
        $base64 = '';

        if (strlen($hex) & 1) {
            throw new \Exception('Invalid string length.');
        }

        $buffer = 0;
        $bufferSize = 0;

        for ($i = 0; $i < strlen($hex); $i++) {
            $character = $hex[$i];
            $decValue = $this->hexToDec($character);
            $bufferSize += 4;
            $buffer = ($buffer << 4) | $decValue;

            if ($bufferSize >= 6) {
                $bufferSize -= 6;
                $base64 .= $this->base64Character(($buffer >> $bufferSize) & 63);
            }
        }

        return $base64;
    }

    public function base64Character(int $value): string
    {
        return $this->base64Map[$value];
    }

    public function base64ToHex(string $base64): string
    {
        $hex = '';

        $base64 = rtrim($base64, '=');

        $buffer = 0;
        $bufferSize = 0;

        for ($i = 0; $i < strlen($base64); $i++) {
            $character = $base64[$i];
            $decValue = $this->base64ToDec($character);
            $bufferSize += 6;
            $buffer = ($buffer << 6) | $decValue;

            while ($bufferSize >= 8) {
                $bufferSize -= 8;
                $hex .= $this->decToHexDouble(($buffer >> $bufferSize) & 255);
            }
        }

        return $hex;
    }

    private function base64ToDec(string $character): int
    {
        $value = strpos($this->base64Map, $character);

        if ($value === false) {
            throw new InvalidLetterException($character . ' is not a valid base64 value.');
        }

        return $value;
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
}
