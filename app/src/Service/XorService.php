<?php

namespace Sventendo\Cryptopals\Service;

class XorService
{
    /**
     * @var string
     */
    private $output = '';

    /**
     * @var ConversionService
     */
    private $conversionService;

    public function __construct(
        ConversionService $conversionService
    ) {
        $this->conversionService = $conversionService;
    }

    public function xor(string $input, string $modifier): string
    {
        $inputLength = strlen($input);

        if ($inputLength !== strlen($modifier)) {
            throw new \Exception('Input and modifier length do not match.');
        }

        for ($i = 0; $i < $inputLength; $i++) {
            $this->output .= $this->xorCharacter($input[$i], $modifier[$i]);
        }

        return $this->output;
    }

    public function xorCharacter(string $input, string $modifier)
    {
        $inputValue = $this->conversionService->hexToDec($input);
        $modifierValue = $this->conversionService->hexToDec($modifier);

        $output = $inputValue ^ $modifierValue;

        return $this->conversionService->decToHex($output);
    }

    public function findXorModifier(string $input, string $output)
    {
        $inputValue = $this->conversionService->hexDoubleToDec($input);
        $outputValue = $this->conversionService->hexDoubleToDec($output);

        // xor operation is commutative: a ^ b = c, and also a ^ c = b
        // therefore to find the modifier b, we use b = a ^ c
        $modifier = $inputValue ^ $outputValue;

        return $modifier;
    }

    public function xorHexDouble(string $inputHexDouble, string $modifierHexDouble)
    {
        $inputValue = $this->conversionService->hexDoubleToDec($inputHexDouble);
        $modifierValue = $this->conversionService->hexDoubleToDec($modifierHexDouble);

        $output = $inputValue ^ $modifierValue;

        return $this->conversionService->decToHexDouble($output);
    }
}
