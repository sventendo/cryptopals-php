<?php

namespace Sventendo\Cryptopals\Tests;

use Illuminate\Container\Container;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->container = new Container();
        parent::__construct($name, $data, $dataName);
    }
}
