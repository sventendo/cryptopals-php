<?php declare(strict_types=1);

namespace Sventendo\Cryptopals\Tests\Set1;

use Sventendo\Cryptopals\Set1\Challenge1;
use Sventendo\Cryptopals\Tests\TestCase;

class Challenge1Test extends TestCase
{
    /**
     * @var Challenge1
     */
    protected $subject;

    public function setUp()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
        $this->subject = $this->container->make(Challenge1::class);
    }

    /**
     * @dataProvider encryptExamples
     * @param string $hex
     * @param string $base64
     * @throws \Exception
     */
    public function testHexToBase64(string $hex, string $base64)
    {
        $this->assertEquals($base64, $this->subject->execute($hex));
    }

    public function encryptExamples(): array
    {
        return [
            [
                '000000',
                'AAAA',
            ],
            [
                'aaaaaa',
                'qqqq',
            ],
            [
                '123456',
                'EjRW',
            ],
            [
                '49276d206b696c6c696e6720796f757220627261696e206c696b65206120706f69736f6e6f7573206d757368726f6f6d',
                'SSdtIGtpbGxpbmcgeW91ciBicmFpbiBsaWtlIGEgcG9pc29ub3VzIG11c2hyb29t',
            ],
        ];
    }
}
