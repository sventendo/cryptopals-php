<?php

namespace Sventendo\Cryptopals\Tests\Service;

use Sventendo\Cryptopals\Service\HammingService;
use Sventendo\Cryptopals\Tests\TestCase;

class HammingServiceTest extends TestCase
{
    /**
     * @var HammingService
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(HammingService::class);
    }

    public function testGetDistance()
    {
        $from = 'this is a test';
        $to = 'wokka wokka!!!';

        $this->assertEquals(37, $this->subject->getDistance($from, $to));
    }
}
