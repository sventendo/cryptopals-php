<?php

namespace Sventendo\Cryptopals\Set1;

use Sventendo\Cryptopals\Service\XorService;

class Challenge5
{
    private $input = 'Burning \'em, if you ain\'t quick and nimble' . PHP_EOL . 'I go crazy when I hear a cymbal';
    /**
     * @var XorService
     */
    private $xorService;

    public function __construct(
        XorService $xorService
    ) {
        $this->xorService = $xorService;
    }

    public function execute()
    {
        return $this->xorService->xorStringRepeat($this->input, 'ICE');
    }
}
