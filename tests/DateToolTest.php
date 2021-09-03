<?php

use Common\Tool\DateTool;
use DateTime;
use PHPUnit\Framework\TestCase;

class DateToolTest extends TestCase
{
    public function correctConvertToDateDataProvider()
    {
        return [
            [(new DateTime), (new DateTime)->setTime(0, 0, 0)],
        ];
    }

    /**
     * @dataProvider correctConvertToDateDataProvider
     * @test
     */
    public function correctConvertToDateTest($input, $expectation): void
    {
        $output = DateTool::convertToDate($input);
        self::assertEquals($output, $expectation);
    }


    public function correctGreaterDateDataProvider()
    {
        $now = (new DateTime);
        return [
            [
                (new DateTime)->setDate($now->format('Y') + 1, $now->format('m'), $now->format('d')),
                (new DateTime),
                true
            ],
            [
                (new DateTime),
                (new DateTime),
                false
            ],
            [
                $now,
                $now,
                false
            ],
            [
                (new DateTime)->setDate($now->format('Y') - 1, $now->format('m'), $now->format('d')),
                (new DateTime),
                false
            ],
        ];
    }

    /**
     * @dataProvider correctGreaterDateDataProvider
     * @test
     */
    public function correctGreaterDateTest($date1, $date2, $expectation): void
    {
        $output = DateTool::greaterDate($date1, $date2);
        self::assertEquals($output, $expectation);
    }


    public function correctSmallerDateDataProvider()
    {
        $now = (new DateTime);
        return [
            [
                (new DateTime)->setDate($now->format('Y') + 1, $now->format('m'), $now->format('d')),
                (new DateTime),
                false
            ],
            [
                (new DateTime),
                (new DateTime),
                false
            ],
            [
                $now,
                $now,
                false
            ],
            [
                (new DateTime)->setDate($now->format('Y') - 1, $now->format('m'), $now->format('d')),
                (new DateTime),
                true
            ],
        ];
    }

    /**
     * @dataProvider correctSmallerDateDataProvider
     * @test
     */
    public function correctSmallerDateTest($date1, $date2, $expectation): void
    {
        $output = DateTool::smallerDate($date1, $date2);
        self::assertEquals($output, $expectation);
    }


    public function correctSameDateDataProvider()
    {
        $now = (new DateTime);
        $hour = $now->format('G');
        if ($hour == 0) {
            $changedHour = $hour + 1;
        } else {
            $changedHour = $hour - 1;
        }
        return [
            [
                $now,
                $now,
                true
            ],
            [
                (new DateTime),
                (new DateTime),
                true
            ],
            [
                (new DateTime),
                (new DateTime)->setTime($changedHour, $now->format('i'), $now->format('s')),
                true
            ],
            [
                (new DateTime)->setDate($now->format('Y') - 1, $now->format('m'), $now->format('d')),
                (new DateTime),
                false
            ],
        ];
    }

    /**
     * @dataProvider correctSameDateDataProvider
     * @test
     */
    public function correctSameDateTest($date1, $date2, $expectation): void
    {
        $output = DateTool::sameDate($date1, $date2);
        self::assertEquals($output, $expectation);
    }


    public function correctGreaterOrSameDateDataProvider()
    {
        $now = (new DateTime);
        $hour = $now->format('G');
        if ($hour == 0) {
            $changedHour = $hour + 1;
        } else {
            $changedHour = $hour - 1;
        }
        return [
            [
                (new DateTime),
                (new DateTime),
                true
            ],
            [
                (new DateTime),
                (new DateTime)->setTime($changedHour, $now->format('i'), $now->format('s')),
                true
            ],
            [
                (new DateTime)->setDate($now->format('Y') + 1, $now->format('m'), $now->format('d')),
                (new DateTime),
                true
            ],
            [
                (new DateTime)->setDate($now->format('Y') - 1, $now->format('m'), $now->format('d')),
                (new DateTime),
                false
            ],
        ];
    }

    /**
     * @dataProvider correctGreaterOrSameDateDataProvider
     * @test
     */
    public function correctGreaterOrSameDateTest($date1, $date2, $expectation): void
    {
        $output = DateTool::greaterOrSameDate($date1, $date2);
        self::assertEquals($output, $expectation);
    }


    public function correctSmallerOrSameDateDataProvider()
    {
        $now = (new DateTime);
        $hour = $now->format('G');
        if ($hour == 0) {
            $changedHour = $hour + 1;
        } else {
            $changedHour = $hour - 1;
        }
        return [
            [
                $now,
                $now,
                true
            ],
            [
                (new DateTime),
                (new DateTime),
                true
            ],
            [
                (new DateTime),
                (new DateTime)->setTime($changedHour, $now->format('i'), $now->format('s')),
                true
            ],
            [
                (new DateTime)->setDate($now->format('Y') - 1, $now->format('m'), $now->format('d')),
                (new DateTime),
                true
            ],
            [
                (new DateTime)->setDate($now->format('Y') + 1, $now->format('m'), $now->format('d')),
                (new DateTime),
                false
            ],
        ];
    }

    /**
     * @dataProvider correctSmallerOrSameDateDataProvider
     * @test
     */
    public function correctSmallerOrSameDateTest($date1, $date2, $expectation): void
    {
        $output = DateTool::smallerOrSameDate($date1, $date2);
        self::assertEquals($output, $expectation);
    }


    public function correctInDateRangeDataProvider()
    {
        $now = (new DateTime);
        return [
            [
                (new DateTime),
                (new DateTime),
                (new DateTime),
                true
            ],
            [
                (new DateTime),
                (new DateTime)->setDate($now->format('Y') - 1, $now->format('m'), $now->format('d')),
                (new DateTime)->setDate($now->format('Y') + 1, $now->format('m'), $now->format('d')),
                true
            ],
            [
                (new DateTime)->setDate($now->format('Y') + 10, $now->format('m'), $now->format('d')),
                (new DateTime)->setDate($now->format('Y') - 1, $now->format('m'), $now->format('d')),
                (new DateTime),
                false
            ],
        ];
    }

    /**
     * @dataProvider correctInDateRangeDataProvider
     * @test
     */
    public function correctInDateRangeTest($date, $dateStart, $dateEnd, $expectation): void
    {
        $output = DateTool::inDateRange($date, $dateStart, $dateEnd);
        self::assertEquals($output, $expectation);
    }


    public function correctDatesOverlapDataProvider()
    {
        $now = (new DateTime)->setTime(0, 0, 0);
        return [
            [
                (new DateTime)->setTime(0, 0, 0),
                (new DateTime)->setTime(0, 0, 0),
                (new DateTime)->setTime(0, 0, 0),
                (new DateTime)->setTime(0, 0, 0),
                1
            ],

            [
                (new DateTime)->setDate($now->format('Y') - 1, $now->format('m'), $now->format('d'))->setTime(0, 0, 0),
                (new DateTime)->setTime(0, 0, 0),
                (new DateTime)->setTime(0, 0, 0),
                (new DateTime)->setDate($now->format('Y') + 1, $now->format('m'), $now->format('d'))->setTime(0, 0, 0),
                1
            ],
            [
                (new DateTime)->setTime(0, 0, 0),
                (new DateTime)->setDate($now->format('Y') + 1, $now->format('m'), $now->format('d'))->setTime(0, 0, 0),
                (new DateTime)->setDate($now->format('Y') - 1, $now->format('m'), $now->format('d'))->setTime(0, 0, 0),
                (new DateTime)->setTime(0, 0, 0),
                1
            ],

            [
                (new DateTime)->setDate(2019, 1, 1)->setTime(0, 0, 0),
                (new DateTime)->setDate(2019, 1, 20)->setTime(0, 0, 0),
                (new DateTime)->setDate(2019, 1, 10)->setTime(0, 0, 0),
                (new DateTime)->setDate(2019, 1, 20)->setTime(0, 0, 0),
                11
            ],

            [
                (new DateTime)->setDate(2019, 1, 10)->setTime(0, 0, 0),
                (new DateTime)->setDate(2019, 1, 20)->setTime(0, 0, 0),
                (new DateTime)->setDate(2019, 1, 1)->setTime(0, 0, 0),
                (new DateTime)->setDate(2019, 1, 20)->setTime(0, 0, 0),
                11
            ],

            // Proof of the necessity of ordering of the dates
            [
                (new DateTime)->setDate(2019, 1, 20)->setTime(0, 0, 0),
                (new DateTime)->setDate(2019, 1, 1)->setTime(0, 0, 0),
                (new DateTime)->setDate(2019, 1, 20)->setTime(0, 0, 0),
                (new DateTime)->setDate(2019, 1, 10)->setTime(0, 0, 0),
                0
            ],
        ];
    }

    /**
     * @dataProvider correctDatesOverlapDataProvider
     * @test
     */
    public function correctDatesOverlapTest($dateStart, $dateEnd, $date2Start, $date2End, $expectation): void
    {
        $output = DateTool::datesOverlap($dateStart, $dateEnd, $date2Start, $date2End);
        self::assertEquals($output, $expectation);
    }


    public function correctAddMonthsDataProvider()
    {
        return [
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10),
                1,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 2, 10),
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10),
                4,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 5, 10),
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2018, 10, 10),
                7,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 5, 10),
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2018, 12, 31),
                2,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 2, 28),
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 2, 28),
                2,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 4, 28),
            ],
        ];
    }

    /**
     * @dataProvider correctAddMonthsDataProvider
     * @test
     */
    public function correctAddMonthsTest($date, $number, $expectation): void
    {
        $output = DateTool::addMonths($date, $number);
        self::assertEquals($output, $expectation);
    }


    public function correctAddDaysDataProvider()
    {
        return [
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10),
                31,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 2, 10),
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10),
                1,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 11),
            ],
            // TODO what is the point for removeDays function
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10),
                -1,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 9),
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 31),
                2,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 2, 2),
            ],
        ];
    }

    /**
     * @dataProvider correctAddDaysDataProvider
     * @test
     */
    public function correctAddDaysTest($date, $number, $expectation): void
    {
        $output = DateTool::addDays($date, $number);
        self::assertEquals($output, $expectation);
    }


    public function correctRemoveDaysDataProvider()
    {
        return [
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 2, 10),
                31,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10),
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 11),
                1,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10),
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 9),
                -1,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10),
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 2, 2),
                2,
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 31),
            ],
        ];
    }

    /**
     * @dataProvider correctRemoveDaysDataProvider
     * @test
     */
    public function correctRemoveDaysTest($date, $number, $expectation): void
    {
        $output = DateTool::removeDays($date, $number);
        self::assertEquals($output, $expectation);
    }


    /**
     * @test
     */
    public function currentDateTest(): void
    {
        $output = DateTool::currentDate();
        self::assertEquals($output, (new DateTime)->setTime(0, 0, 0));
        self::assertEquals($output, new DateTime('today'));
    }


    public function correctGetDaysBetweenDatesDataProvider()
    {
        return [
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10),
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 2, 10),
                31,
            ],
            [
                (new DateTime)->setTime(0, 0, 0),
                (new DateTime)->setTime(0, 0, 0),
                0,
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2018, 12, 10),
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 4, 10),
                121,
            ],
        ];
    }

    /**
     * @dataProvider correctGetDaysBetweenDatesDataProvider
     * @test
     */
    public function correctGetDaysBetweenDatesTest($date, $date2, $expectation): void
    {
        $output = DateTool::getDaysBetweenDates($date, $date2);
        self::assertEquals($output, $expectation);
    }


    public function correctValidDataProvider()
    {
        return [
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10),
                true,
            ],
            [
                (new DateTime)->setTime(0, 0, 0)->setDate(2019, 1, 10)->format('blooperiino'),
                false,
            ],
        ];
    }

    /**
     * @dataProvider correctValidDataProvider
     * @test
     */
    public function correctValidTest($date, $expectation): void
    {
        $output = DateTool::valid($date);
        self::assertEquals($output, $expectation);
    }


    public function correctYesterdayDateDataProvider()
    {
        $yesterday = (new DateTime())->setTime(0, 0, 0);
        $yesterday->sub(new \DateInterval('P1D'));
        return [
            [
                $yesterday,
            ]
        ];
    }

    /**
     * @dataProvider correctYesterdayDateDataProvider
     * @test
     */
    public function correctYesterdayDateTest($expectation): void
    {
        $output = DateTool::yesterdayDate();
        self::assertEquals($output, $expectation);
    }

    /**
     * @test
     */
    public function toText()
    {
        $date = new DateTime('2019-05-05');
        $output = DateTool::toText($date, '');
        self::assertSame('May 5th 2019', $output);
        $output = DateTool::toText($date, 'le');
        self::assertSame('May 5th 2019', $output);
        $output = DateTool::toText($date, 'ke');
        self::assertSame('May 5th 2019', $output);
    }
}
