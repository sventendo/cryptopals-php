<?php

namespace Sventendo\Cryptopals\Service;

use Sventendo\Cryptopals\TestCase;

class ConversionServiceTest extends TestCase
{
    /**
     * @var ConversionService
     */
    private $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(ConversionService::class);
    }

    public function testDecToDoubleHex()
    {
        $this->assertEquals('61', $this->subject->decToHexDouble(97));
    }
}
