<?php declare(strict_types=1);

namespace Sventendo\Cryptopals\Tests\Set1;

use Sventendo\Cryptopals\Set1\Challenge2;
use Sventendo\Cryptopals\Tests\TestCase;

class Challenge2Test extends TestCase
{
    /**
     * @var Challenge2
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(Challenge2::class);
    }

    public function testExecute()
    {
        $input = '1c0111001f010100061a024b53535009181c';
        $modifier = '686974207468652062756c6c277320657965';
        $expected = '746865206b696420646f6e277420706c6179';

        $actual = $this->subject->execute($input, $modifier);

        $this->assertEquals($expected, $actual);
    }
}
