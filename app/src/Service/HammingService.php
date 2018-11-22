<?php

namespace Sventendo\Cryptopals\Service;

use Sventendo\Cryptopals\Exceptions\InvalidHexValueException;
use Sventendo\Cryptopals\Exceptions\InvalidLetterException;
use Sventendo\Cryptopals\Exceptions\InvalidStringLengthException;
use Sventendo\Cryptopals\ValueTypes\HexDouble;

class HammingService
{
    // @formatter:off
    private $bitMap256 = [
        0, 1,


        1, 2,


        1, 2, 2, 3,


        1, 2, 2, 3,
        2, 3, 3, 4,


        1, 2, 2, 3,
        2, 3, 3, 4,
        2, 3, 3, 4,
        3, 4, 4, 5,


        1, 2, 2, 3,
        2, 3, 3, 4,
        2, 3, 3, 4,
        3, 4, 4, 5,

        2, 3, 3, 4,
        3, 4, 4, 5,
        3, 4, 4, 5,
        4, 5, 5, 6,


        1, 2, 2, 3,
        2, 3, 3, 4,
        2, 3, 3, 4,
        3, 4, 4, 5,

        2, 3, 3, 4,
        3, 4, 4, 5,
        3, 4, 4, 5,
        4, 5, 5, 6,

        2, 3, 3, 4,
        3, 4, 4, 5,
        3, 4, 4, 5,
        4, 5, 5, 6,

        3, 4, 4, 5,
        4, 5, 5, 6,
        4, 5, 5, 6,
        5, 6, 6, 7,


        1, 2, 2, 3,
        2, 3, 3, 4,
        2, 3, 3, 4,
        3, 4, 4, 5,

        2, 3, 3, 4,
        3, 4, 4, 5,
        3, 4, 4, 5,
        4, 5, 5, 6,

        2, 3, 3, 4,
        3, 4, 4, 5,
        3, 4, 4, 5,
        4, 5, 5, 6,

        3, 4, 4, 5,
        4, 5, 5, 6,
        4, 5, 5, 6,
        5, 6, 6, 7,

        2, 3, 3, 4,
        3, 4, 4, 5,
        3, 4, 4, 5,
        4, 5, 5, 6,

        3, 4, 4, 5,
        4, 5, 5, 6,
        4, 5, 5, 6,
        5, 6, 6, 7,

        3, 4, 4, 5,
        4, 5, 5, 6,
        4, 5, 5, 6,
        5, 6, 6, 7,

        4, 5, 5, 6,
        5, 6, 6, 7,
        5, 6, 6, 7,
        6, 7, 7, 8
    ];
    // @formatter:on

    /**
     * @var ConversionService
     */
    private $conversionService;

    public function __construct(
        ConversionService $conversionService
    ) {
        $this->conversionService = $conversionService;
    }

    public function getDistance(string $from, string $to): int
    {
        if (strlen($from) !== strlen($to)) {
            throw new InvalidStringLengthException('Strings must be of equal length.');
        }

        $distance = 0;

        for ($i = 0; $i < strlen($from); $i++) {

            $fromValue = ord($from[$i]);
            $toValue = ord($to[$i]);

            if ($fromValue > 255) {
                throw new InvalidLetterException($from[$i] . ' (value ' . $fromValue . ')is not a valid ascii character');
            }

            if ($toValue > 255) {
                throw new InvalidLetterException($to[$i] . ' (value ' . $toValue . ')is not a valid ascii character');
            }

            $differingValue = $fromValue ^ $toValue;

            $distanceForCharacter = $this->countSetBits($differingValue);

            $distance += $distanceForCharacter;
        }

        return $distance;
    }

    public function getHexDoubleDistance(HexDouble $from, HexDouble $to): int
    {
        $fromValue = $this->conversionService->hexDoubleToDec($from);
        $toValue = $this->conversionService->hexDoubleToDec($to);
        $differingValue = $fromValue ^ $toValue;

        return $this->countSetBits($differingValue);
    }

    private function countSetBits(int $differingValue)
    {
        if ($differingValue > count($this->bitMap256)) {
            throw new InvalidHexValueException($differingValue . ' is not a valid hex double value');
        }

        return $this->bitMap256[$differingValue];
    }
}
