<?php

namespace Sventendo\Cryptopals\Service;

use Sventendo\Cryptopals\Exceptions\InvalidLetterException;
use Sventendo\Cryptopals\Set1\Challenge6\Message;
use Sventendo\Cryptopals\ValueTypes\HexDouble;

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

    public function findXorModifier(HexDouble $input, HexDouble $output)
    {
        $inputValue = $this->conversionService->hexDoubleToDec($input);
        $outputValue = $this->conversionService->hexDoubleToDec($output);

        // xor operation is commutative: a ^ b = c, and also a ^ c = b
        // therefore to find the modifier b, we use b = a ^ c
        $modifier = $inputValue ^ $outputValue;

        return $modifier;
    }

    public function xorHexDoubleWithHexDouble(HexDouble $input, HexDouble $modifierHexDouble)
    {
        $modifierValue = $this->conversionService->hexDoubleToDec($modifierHexDouble);

        return $this->xorHexDoubleWithValue($input, $modifierValue);
    }

    public function xorHexDoubleWithValue(HexDouble $input, int $modifierValue)
    {
        $inputValue = $this->conversionService->hexDoubleToDec($input);

        $output = $inputValue ^ $modifierValue;

        return $this->conversionService->decToHexDouble($output);
    }

    public function xorString(string $input, int $modifierValue)
    {
        $message = '';

        foreach (str_split($input, 2) as $index => $chunk) {
            $hexDouble = new HexDouble($chunk);
            $hexDoubleDecrypted = $this->xorHexDoubleWithValue($hexDouble, $modifierValue);
            try {
                $this->conversionService->sanitizeHexDouble($hexDoubleDecrypted);
            } catch (InvalidLetterException $e) {
                return '';
            }
            $message .= $this->conversionService->hexDoubleToAscii($hexDoubleDecrypted);
        }

        return $message;
    }

    public function xorStringToMessage(string $input, int $modifierValue): Message
    {
        $message = new Message();
        $message->setModifierValue($modifierValue);
        $hitRate = 0;

        foreach (str_split($input, 2) as $index => $chunk) {
            if (strlen($chunk) === 1) {
                $chunk .= '0';
            }
            $hexDouble = new HexDouble($chunk);
            $hexDoubleDecrypted = $this->xorHexDoubleWithValue($hexDouble, $modifierValue);
            $hitRate++;
            try {
                $this->conversionService->sanitizeHexDouble($hexDoubleDecrypted);
            } catch (InvalidLetterException $e) {
                $hitRate--;
            }
            $message->addText($this->conversionService->hexDoubleToAscii($hexDoubleDecrypted));
        }

        $message->setHitRate($hitRate / (strlen($input) / 2));

        return $message;
    }

    public function xorStringRepeat(string $input, string $modifierString)
    {
        $message = '';

        $modifierLength = strlen($modifierString);

        foreach (str_split($input) as $index => $chunk) {
            $chunkValue = ord($chunk);
            $modifierValue = ord($modifierString[$index % $modifierLength]);
            $message .= $this->conversionService->decToHexDouble($chunkValue ^ $modifierValue)->__toString();
        }

        return $message;
    }
}
