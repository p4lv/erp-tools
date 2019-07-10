<?php


namespace Common\Tool;


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

        $test = Financial::PMT(0.1, 0,2, 0);
        var_dump($test);exit;
    }
}