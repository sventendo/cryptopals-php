<?php declare(strict_types=1);

namespace Sventendo\Cryptopals\Set1;

use Sventendo\Cryptopals\Service\ConversionService;

class Challenge1
{

    /**
     * @var ConversionService
     */
    private $conversionService;

    public function __construct(
        ConversionService $conversionService
    ) {
        $this->conversionService = $conversionService;
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
            $decValue = $this->conversionService->hexToDec($character);
            $bufferSize += 4;
            $buffer = ($buffer << 4) | $decValue;

            if ($bufferSize >= 6) {
                $bufferSize -= 6;
                $base64 .= $this->conversionService->base64Character(($buffer >> $bufferSize) & 63);
            }
        }

        return $base64;
    }
}
