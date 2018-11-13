<?php

namespace Sventendo\Cryptopals\Tests\Set1;

use Sventendo\Cryptopals\Set1\Challenge5;
use Sventendo\Cryptopals\Tests\TestCase;

class Challenge5Test extends TestCase
{
    /**
     * @var Challenge5
     */
    private $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(Challenge5::class);
    }

    public function testExecute()
    {
        $expected = '0b3637272a2b2e63622c2e69692a23693a2a3c6324202d623d63343c2a26226324272765272'
            . 'a282b2f20430a652e2c652a3124333a653e2b2027630c692b20283165286326302e27282f';
        $this->assertEquals($expected, $this->subject->execute());
    }
}
