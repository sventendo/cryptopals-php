<?php

namespace Sventendo\Cryptopals\Set1;

use Sventendo\Cryptopals\Exceptions\InvalidLetterException;
use Sventendo\Cryptopals\Service\ConversionService;
use Sventendo\Cryptopals\Service\XorService;
use Sventendo\Cryptopals\ValueTypes\HexDouble;

class Challenge3
{
    /**
     * @var string
     */
    private $challengeInput = '1b37373331363f78151b7f2b783431333d78397828372d363c78373e783a393b3736';

    /**
     * @var array
     */
    private $decryptedCandidates = [];

    /**
     * We could brute force the solution. But let's look at what makse sense.
     * The second and third letter is encoded with as "37".
     * The only existing double vowel as "ee" as in "beer" or "oo" as in "door".
     * if the second and third letter is not a vowel, then the first letter "1b" must be a vowel.
     *
     * @var array
     */
    private $possibleMatches = [
        ['37', 'e'],
        ['37', 'o'],
        ['1b', 'a'],
        ['1b', 'e'],
        ['1b', 'i'],
        ['1b', 'o'],
        ['1b', 'u'],
    ];

    /**
     * @var ConversionService
     */
    private $conversionService;

    /**
     * @var XorService
     */
    private $xorService;

    public function __construct(
        ConversionService $conversionService,
        XorService $xorService
    ) {
        $this->conversionService = $conversionService;
        $this->xorService = $xorService;
    }

    public function execute(): array
    {
        foreach ($this->possibleMatches as $match) {
            $encodedLetter = $this->conversionService->decToHexDouble(ord($match[1]));
            $modifier = $this->xorService->findXorModifier(new HexDouble($match[0]), $encodedLetter);
            try {
                $this->decryptedCandidates[] = $this->decrypt($modifier);
            } catch (InvalidLetterException $e) {
            }
        }

        return $this->decryptedCandidates;
    }

    private function decrypt(int $modifier): string
    {
        $message = '';

        $modifierAsHex = $this->conversionService->decToHexDouble($modifier);

        foreach (str_split($this->challengeInput, 2) as $hexDoubleString) {
            $doubleHex = new HexDouble($hexDoubleString);
            $message .= $this->decryptLetter($doubleHex, $modifierAsHex);
        }

        return $message;
    }

    private function decryptLetter(HexDouble $input, HexDouble $modifierHexDouble, bool $sanitize = true): string
    {
        $letter = chr($this->conversionService->hexDoubleToDec(
            $this->xorService->xorHexDoubleWithHexDouble($input, $modifierHexDouble)
        ));

        if ($sanitize) {
            if (!strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/ ,.-_()[]{}\'"', $letter)) {
                throw new InvalidLetterException('Letter "' . $letter . '" is not in the list of valid letters.');
            }
        }

        return $letter;
    }
}
