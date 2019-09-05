<?php

namespace Test\Common\Tool;

use Common\Tool\FtpSimpleClient;
use PHPUnit\Framework\TestCase;

class FtpSimpleClientTest extends TestCase
{

    /**
     * @test
     */
    public function constructorTest()
    {
        $ftp = new FtpSimpleClient();
    }
}