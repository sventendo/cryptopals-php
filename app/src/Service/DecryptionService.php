<?php

namespace Sventendo\Cryptopals\Service;

use Sventendo\Cryptopals\Set1\Challenge6\Message;

class DecryptionService
{
    /**
     * @var XorService
     */
    private $xorService;


    public function __construct(
        XorService $xorService
    ) {
        $this->xorService = $xorService;
    }

    public function getSensibleDecryptedStrings(string $input): array
    {
        $messages = [];
        for ($i = 0; $i < 256; $i++) {
            $message = $this->xorService->xorString($input, $i);
            if ($message !== '') {
                $messages[$i] = $message;
            }
        }

        return $messages;
    }

    public function getDecryptionKeyValue(string $input): string
    {
        $decryptionKey = '';

        /** @var Message[] $messages */
        $messages = $this->getDecryptedStringsWithHitRate($input);

        usort($messages, function (Message $a, Message $b) {
            return $a->getHitRate() < $b->getHitRate();
        });

        $bestFit = $messages[0];

        if (\count($messages)) {
            $decryptionKey = $bestFit->getModifierValue();
        } else {
            echo 'No sensible decryption key found.' . PHP_EOL;
        }

        echo 'Decryption key with best fit: ' . $decryptionKey . '(Hit rate: ' . $bestFit->getHitRate() . ')' . PHP_EOL;
        echo 'Decrypted chunk: ' . $messages[0]->getText() . PHP_EOL;

        return $decryptionKey;
    }

    private function getDecryptedStringsWithHitRate(string $input): array
    {
        $messages = [];
        for ($i = 0; $i < 256; $i++) {
            $message = $this->xorService->xorStringToMessage($input, $i);
            $messages[$i] = $message;
        }

        return $messages;
    }

    public function getDecryptionKeyCandidates(string $input): array
    {
        $messages = $this->getDecryptedStringsWithHitRate($input);

        usort($messages, function (Message $a, Message $b) {
            return $a->getHitRate() > $b->getHitRate();
        });

        return array_slice($messages, 0, 1);
    }
}
