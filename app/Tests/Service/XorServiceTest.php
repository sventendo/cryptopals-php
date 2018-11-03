<?php

namespace Sventendo\Cryptopals\Service;

use Sventendo\Cryptopals\TestCase;

class XorServiceTest extends TestCase
{
    /**
     * @var XorService
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(XorService::class);
    }

    /**
     * @param string $input
     * @param string $modifier
     * @param string $output
     *
     * @dataProvider xorCharacterExamples
     */
    public function testXorCharacter(string $input, string $modifier, string $output)
    {
        $this->assertEquals($output, $this->subject->xorCharacter($input, $modifier));
    }

    public function xorCharacterExamples()
    {
        return [
            ['6', '1', '7'],
            ['4', '5', '1'],
        ];
    }

    public function testXor()
    {
        $input = '1c0111001f010100061a024b53535009181c';
        $modifier = '686974207468652062756c6c277320657965';
        $output = '746865206b696420646f6e277420706c6179';

        $this->assertEquals($output, $this->subject->xor($input, $modifier));
    }
}
