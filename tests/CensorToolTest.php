<?php


use Common\Tool\Censor;
use PHPUnit\Framework\TestCase;

class CensorToolTest extends TestCase
{
    public function correctCensureDataProvider()
    {
        return [
            [null,null],
            ['',''],
            ['1','█'],
            ['qwertyuiop','██████████'],
        ];
    }

    /**
     * @test
     * @dataProvider correctCensureDataProvider
     */
    public function correctCensureTest($string, $expectedResult)
    {
        $actualResult = Censor::censure($string);
        self::assertSame($expectedResult,$actualResult);
    }

}