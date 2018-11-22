<?php

namespace Sventendo\Cryptopals\Set1;

use Sventendo\Cryptopals\Service\ConversionService;
use Sventendo\Cryptopals\Service\DecryptionService;
use Sventendo\Cryptopals\Service\HammingService;
use Sventendo\Cryptopals\Service\KeyScoreService;
use Sventendo\Cryptopals\Service\XorService;
use Sventendo\Cryptopals\Set1\Challenge6\KeyLengthEvaluator;

class Challenge6
{
    /**
     * @var string
     */
    private $input = '';
    /**
     * @var ConversionService
     */
    private $conversionService;
    /**
     * @var HammingService
     */
    private $hammingService;
    /**
     * @var DecryptionService
     */
    private $decryptionService;

    private $inputLength;
    /**
     * @var KeyScoreService
     */
    private $keyScoreService;
    /**
     * @var KeyLengthEvaluator
     */
    private $keyLengthEvaluator;
    /**
     * @var XorService
     */
    private $xorService;
    /**
     * @var int
     */
    private $keyLength = 0;

    public function __construct(
        ConversionService $conversionService,
        HammingService $hammingService,
        DecryptionService $decryptionService,
        KeyScoreService $keyScoreService,
        KeyLengthEvaluator $keyLengthEvaluator,
        XorService $xorService
    ) {
        $this->conversionService = $conversionService;
        $this->hammingService = $hammingService;
        $this->decryptionService = $decryptionService;
        $this->keyScoreService = $keyScoreService;
        $this->keyLengthEvaluator = $keyLengthEvaluator;
        $this->xorService = $xorService;
    }

    public function execute(string $input)
    {
        $this->initialize($input);
        $this->prepareInput();

        echo 'Input: ' . substr($this->input, 0, 64) . PHP_EOL;

        $this->getKeyLength();

        echo 'Key length found: ' . $this->keyLength . PHP_EOL;

        $decryptedMessage = $this->testKeyCandidates();

        return $decryptedMessage;
    }

    private function initialize(string $input)
    {
        $this->input = $input;
        $this->inputLength = strlen($this->input);

        echo 'Input format: base64, input length: ' . $this->inputLength . PHP_EOL;
    }

    private function prepareInput()
    {
        $this->input = bin2hex(base64_decode($this->input));
        $this->inputLength = strlen($this->input);

        echo 'Input format: hex, input length: ' . $this->inputLength . PHP_EOL;
    }


    private function getKeyLength()
    {
        $this->keyScoreService->setCypher($this->input);
        $this->keyLength = $this->keyScoreService->getKeyLength();
    }

    private function testKeyCandidates(): string
    {
        $this->keyLengthEvaluator->setInput($this->input);
        $key = $this->keyLengthEvaluator->evaluate($this->keyLength);
        echo 'Decryption key: ' . $key . PHP_EOL;

        if ($key !== '') {
            $inputAsAscii = $this->conversionService->hexDoubleStringToAscii($this->input);
            $decryptedInputAsHexDouble = $this->xorService->xorStringRepeat($inputAsAscii, $key);
            $decryptedInput = $this->conversionService->hexDoubleStringToAscii($decryptedInputAsHexDouble);

            return $decryptedInput;
        }

        return '';
    }
}
