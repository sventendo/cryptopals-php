<?php

namespace Sventendo\Cryptopals\Tests\Set1;

use Sventendo\Cryptopals\Set1\Challenge6;
use Sventendo\Cryptopals\Tests\TestCase;

class Challenge6Test extends TestCase
{
    /**
     * @var Challenge6
     */
    private $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(Challenge6::class);
    }

    public function testExecute()
    {
        echo $this->subject->execute($this->getInput()) . PHP_EOL;
    }

    private function getInput(): string
    {
        return str_replace(PHP_EOL, '', file_get_contents(__DIR__ . '/Challenge6/input.txt'));
    }
}
