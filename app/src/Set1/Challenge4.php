<?php

namespace Sventendo\Cryptopals\Set1;

use Sventendo\Cryptopals\Exceptions\InvalidLetterException;
use Sventendo\Cryptopals\Service\ConversionService;
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

    public function __construct(
        ConversionService $conversionService,
        XorService $xorService
    ) {
        $this->conversionService = $conversionService;
        $this->xorService = $xorService;
    }

    public function readChallengeInput()
    {
        $this->input = explode(PHP_EOL, file_get_contents(__DIR__ . '/4.txt'));
    }

    public function execute(): array
    {
        $output = [];

        foreach ($this->input as $row) {
            $messages = $this->getSensibleDecryptedStrings($row);
            if (\count($messages)) {
                $output[] = $messages;
            }
        }

        return $output;
    }

    private function getSensibleDecryptedStrings($row): array
    {
        $messages = [];
        for ($i = 0; $i < 256; $i++) {

            $message = $this->xorService->xorString($row, $i);
            if ($message !== '') {
                $messages[] = $message;
            }
        }

        return $messages;
    }
}
