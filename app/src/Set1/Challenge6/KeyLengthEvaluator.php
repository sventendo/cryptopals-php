<?php

namespace Sventendo\Cryptopals\Set1\Challenge6;

use Sventendo\Cryptopals\Service\DecryptionService;

class KeyLengthEvaluator
{
    private $input = '';
    private $inputLength = 0;
    private $groupedChunks = [];
    /**
     * @var DecryptionService
     */
    private $decryptionService;

    public function __construct(
        DecryptionService $decryptionService
    ) {
        $this->decryptionService = $decryptionService;
    }

    public function setInput(string $input): void
    {
        $this->input = $input;
        $this->inputLength = strlen($this->input);
    }

    public function evaluate(int $keyLength): string
    {
        echo 'Testing key length: ' . $keyLength . PHP_EOL;
        $this->groupChunks($keyLength);

        echo 'Testing ' . \count($this->groupedChunks) . ' grouped chunks with length of ' . strlen($this->groupedChunks[0]) . ' each.' . PHP_EOL;
        $key = '';
        foreach ($this->groupedChunks as $groupedChunk) {
            $decryptionKeyValue = $this->decryptionService->getDecryptionKeyValue($groupedChunk);
            $decryptionKey = chr($decryptionKeyValue);
            echo 'Key segment value: ' . $decryptionKeyValue . PHP_EOL;
            echo 'Key segment: ' . $decryptionKey . PHP_EOL;
            $key .= $decryptionKey;
        }

        return $key;
    }

    private function groupChunks(int $keyLength)
    {
        $this->groupedChunks = [];

        $chunks = str_split($this->input, $keyLength * 2);

        for ($i = 0; $i < $keyLength; $i++) {
            foreach ($chunks as $chunk) {
                if (!isset($this->groupedChunks[$i])) {
                    $this->groupedChunks[$i] = '';
                }
                $this->groupedChunks[$i] .= substr($chunk, $i * 2, 2);
            }
        }
    }

}
