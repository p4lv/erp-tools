<?php


namespace Test\Common\Tool;


use Common\Tool\Financial;
use PHPUnit\Framework\TestCase;

class FinancialTest extends TestCase
{

    /**
     * @test
     */
    public function PMT()
    {
        $test = Financial::PMT(0.1, 1,1, 0);
        self::assertEquals('-1.1', $test);

        $test = Financial::PMT(0, 100,1, 0);

        self::assertSame(-0.01, $test);

        $test = Financial::PMT(-10, 100,1, 0);
        self::assertSame(10., $test);


        $test = Financial::PMT(-1, 100,1, 0);
        self::assertSame(0., $test);

        $test = Financial::PMT(-0.99, 100,1, 0);
        self::assertSame(0., $test);

        $test = Financial::PMT(-0.55, 100,10, 10);
        self::assertSame(-5.5, $test);
    }
}