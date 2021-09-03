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

    /**
     * @test
     * @dataProvider ipmtDataProvider
     */
    public function IPMT(
        $expectedResult,
        $rate,
        $per,
        $nper,
        $pv
    )
    {
        $test = Financial::IPMT($rate, $per, $nper, $pv);
        self::assertSame($expectedResult, $test);
    }


    public function ipmtDataProvider()
    {
        return [
            'case 0' => [null,
                5.0, 0, 12, 12],
            'case -1' => [-60.0,
                5.0, 1, 12, 12],

            'case 112' => [-6666.666666666667,
                //interest rate, installment number, from 1 to max nper , nper -> number oof installpernts in pariod. , //lump sum
                10/12, 1, 3*12, 8000],
            'case 2' => [-72781.95488721877,
                //interest rate, installment number, from 1 to max nper , nper -> number oof installpernts in pariod. , //lump sum
                10.0, 3, 3, 8000],

        ];
    }

    /**
     * @dataProvider ppmtDataProvider
     * @test
     */
    public function PPMT($expectedResult, $rate, $per, $nper, $pv, $fv = 0.0, $type = 0)
    {
        $test = Financial::PPMT($rate, $per, $nper, $pv, $fv, $type);
        self::assertSame($expectedResult, $test);
    }

    public function ppmtDataProvider()
    {
        return [
            'case 1' => [-2.7563622495563322E-8,
                5.0, 1, 12, 12],
            'case 2' => [null,
                5.0, -10, 12, 12
            ]
        ];
    }

    /**
     * @dataProvider xirrDataProvider
     * @test
     */
    public function xirr($excpected, array $values, $timestamps, $guess = 0.1)
    {
        $result = Financial::XIRR($values, $timestamps, $guess);
        self::assertSame($excpected, $result);
    }

    public function xirrDataProvider()
    {
        return [
            'aa' => [
                null, [100, 100, 100,], [
                    strtotime('2021-01-01'),
                    strtotime('2021-02-01'),
                    strtotime('2021-03-01'),
                    ], 1,
            ]
        ];
    }

    /**
     * @test
     * @dataProvider irrDataProvider
     */
    public function irr($expectedResult, $values, $guess) {
        $result = Financial::IRR($values, $guess);

        self::assertSame($expectedResult, $result);
    }

    public function irrDataProvider()
    {
        return [
            'case 1' => [
                null, 1.1, [10, 10, 10 , 10]
            ],
            'case 2' => [
                null, [10, 10, 10 , 10], 1.1
            ],
            'case 21' => [
                null, [100, 80, 70 , 40], 0.1
            ],
            'case 22' => [
                null, [15000, 17000, 10000], 3
            ]

        ];
    }

}