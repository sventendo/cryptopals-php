<?php

namespace Sventendo\Cryptopals\Service;

use Sventendo\Cryptopals\Exceptions\InvalidStringLengthException;
use Sventendo\Cryptopals\ValueTypes\HexDouble;

class KeyScoreService
{
    private $cypher = '';
    private $candidates = [];
    private $keyLength = 0;
    private $hammingService;

    public function __construct(
        HammingService $hammingService
    ) {
        $this->hammingService = $hammingService;
    }

    public function setCypher(string $cypher)
    {
        $this->cypher = $cypher;
    }

    public function getKeyLength()
    {
        $this->calculateCandidates();

        return $this->keyLength;
    }

    private function calculateCandidates(): void
    {
        for ($length = 2; $length < 40; $length++) {
            $this->candidates[$length] = $this->getKeyScore($length);
        }

        asort($this->candidates);

        $this->keyLength = array_keys($this->candidates)[0];
    }

    private function getKeyScore(int $keyLength): float
    {
        $keyLengthInHexCharacters = $keyLength * 2;

        $normalizedDistances = [];
        $sampleCount = 4;

        for ($sample = 0; $sample < $sampleCount; $sample++) {
            $index = rand(0, strlen($this->cypher) / $keyLengthInHexCharacters - 2);
            $offset = $keyLengthInHexCharacters * $index;

            $firstSlice = substr($this->cypher, $offset, $keyLengthInHexCharacters);
            $secondSlice = substr($this->cypher, $offset + $keyLengthInHexCharacters, $keyLengthInHexCharacters);

            $firstSetOfHexDoubleValues = str_split($firstSlice, 2);
            $secondSetOfHexDoubleValue = str_split($secondSlice, 2);

            $totalDistance = 0;

            for ($i = 0; $i < $keyLength; $i++) {
                $totalDistance += $this->hammingService->getHexDoubleDistance(
                    new HexDouble($firstSetOfHexDoubleValues[$i]),
                    new HexDouble($secondSetOfHexDoubleValue[$i])
                );
            }

            $normalizedDistances[] = $totalDistance / $keyLength;
        }

        $normalizedDistance = array_sum($normalizedDistances) / $sampleCount;

        return $normalizedDistance;
    }
}
