<?php

namespace Sventendo\Cryptopals\Tests;

use Illuminate\Container\Container;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct()
    {
        parent::__construct();
        $this->container = new Container();
    }
}
