<?php

namespace Sventendo\Cryptopals\Set1;

use Sventendo\Cryptopals\Service\ConversionService;
use Sventendo\Cryptopals\Service\DecryptionService;
use Sventendo\Cryptopals\Service\XorService;

class Challenge4
{
    /**
     * @var array
     */
    private $input = [];
    /**
     * @var ConversionService
     */
    private $conversionService;
    /**
     * @var XorService
     */
    private $xorService;
    /**
     * @var DecryptionService
     */
    private $decryptionService;

    public function __construct(
        ConversionService $conversionService,
        XorService $xorService,
        DecryptionService $decryptionService
    ) {
        $this->conversionService = $conversionService;
        $this->xorService = $xorService;
        $this->decryptionService = $decryptionService;
    }

    public function readChallengeInput()
    {
        $this->input = explode(PHP_EOL, file_get_contents(__DIR__ . '/4.txt'));
    }

    public function execute(): array
    {
        $output = [];

        foreach ($this->input as $row) {
            $messages = $this->decryptionService->getSensibleDecryptedStrings($row);
            if (\count($messages)) {
                $output[] = $messages;
            }
        }

        return $output;
    }

}
