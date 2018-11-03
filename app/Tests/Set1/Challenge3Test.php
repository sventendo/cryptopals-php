<?php declare(strict_types=1);

namespace Sventendo\Cryptopals\Tests\Set1;

use Sventendo\Cryptopals\Set1\Challenge3;
use Sventendo\Cryptopals\TestCase;

class Challenge3Test extends TestCase
{
    /**
     * @var Challenge3
     */
    private $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(Challenge3::class);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testExecute()
    {
        echo implode(PHP_EOL, $this->subject->execute());
    }
}
