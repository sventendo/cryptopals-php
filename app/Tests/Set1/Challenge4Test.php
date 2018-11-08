<?php

namespace Sventendo\Cryptopals\Tests\Set1;

use Sventendo\Cryptopals\Set1\Challenge4;
use Sventendo\Cryptopals\Tests\TestCase;

class Challenge4Test extends TestCase
{
    /**
     * @var Challenge4
     */
    private $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(Challenge4::class);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDecryptAllAsIs()
    {
        $this->subject->readChallengeInput();
        $output = $this->subject->execute();

        var_dump($output);
    }
}
