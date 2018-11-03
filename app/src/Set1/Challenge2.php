<?php

namespace Sventendo\Cryptopals\Set1;

use Sventendo\Cryptopals\Service\XorService;

class Challenge2
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

    public function execute(string $input, string $modifier)
    {
        return $this->xorService->xor($input, $modifier);
    }
}
