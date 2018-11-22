<?php

namespace Sventendo\Cryptopals\Service;

use Sventendo\Cryptopals\Tests\TestCase;

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

    /**
     * @param string $input
     * @param string $expected
     *
     * @dataProvider base64ToHexExamples
     */
    public function testBase64ToHex(string $input, string $expected)
    {
        $this->assertEquals($expected, $this->subject->base64ToHex($input));
    }

    public function testNativeBase64ToHex()
    {
        $input = str_replace(PHP_EOL, '', file_get_contents(__DIR__ . '/../Set1/Challenge6/input.txt'));
        $expected = bin2hex(base64_decode($input));

        $this->assertEquals($expected, $this->subject->base64ToHex($input));
    }

    public function base64ToHexExamples()
    {
        return [
            ['aa', 69],
            ['aabbcQ==', '69a6db71']
        ];
    }
}
