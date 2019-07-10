<?php

namespace Test\Common\Tool;

use Common\Tool\StringTool;
use PHPUnit\Framework\TestCase;

class StringToolTest extends TestCase
{
    public function correctStartsWithDataProvider()
    {
        return [
            ['', 'a', null, false],
            ['', 'a', false, false],
            ['a', 'a', null, true],
            ['a', 'A', true, false],
            ['A', 'A', null, true],
            ['zzzzzA', 'A', null, false],
        ];
    }

    /**
     * @dataProvider correctStartsWithDataProvider
     * @test
     */
    public function correctStartsWithTest($haystack, $needle, $case = true, $expectation): void
    {
        $output = StringTool::startsWith($haystack, $needle, $case);
        self::assertSame($output, $expectation);
    }


    public function correctEndsWithDataProvider()
    {
        return [
            ['', 'a', null, false],
            ['zza', 'a', null, true],
            ['za', 'A', true, false],
            ['zA', 'A', null, true],
            ['Azzzzz', 'A', null, false],
        ];
    }

    /**
     * @dataProvider correctEndsWithDataProvider
     * @test
     */
    public function correctEndsWithTest($haystack, $needle, $case = true, $expectation): void
    {
        $output = StringTool::endsWith($haystack, $needle, $case);
        self::assertSame($output, $expectation);
    }


    public function correctContainsDataProvider()
    {
        return [
            ['', 'a', false],
            ['zza', 'a', true],
            ['za', 'A', false],
            ['zA', 'A', true],
            ['Azzzzz', 'A', true],
        ];
    }

    /**
     * @dataProvider correctContainsDataProvider
     * @test
     */
    public function correctContainsTest($haystack, $needle, $expectation): void
    {
        $output = StringTool::contains($haystack, $needle);
        self::assertSame($output, $expectation);
    }


    public function correctCapitalizeFirstLetterDataProvider()
    {
        return [
            ['', ''],
            ['aaa', 'Aaa'],
        ];
    }

    /**
     * @dataProvider correctCapitalizeFirstLetterDataProvider
     * @test
     */
    public function correctCapitalizeFirstLetterTest($string, $expectation): void
    {
        $output = StringTool::capitalizeFirstLetter($string);
        self::assertSame($output, $expectation);
    }


    public function correctRemovePrefixDataProvider()
    {
        return [
            ['', '', ''],
            ['abcdef', '', 'abcdef'],
            ['abcdef', 'abc', 'def'],
        ];
    }

    /**
     * @dataProvider correctRemovePrefixDataProvider
     * @test
     */
    public function correctRemovePrefixTest($string, $prefix, $expectation): void
    {
        $output = StringTool::removePrefix($string, $prefix);
        self::assertSame($output, $expectation);
    }


    public function correctConvertAsciiDataProvider()
    {
        return [
            ['', ''],
            ['tiņš', 'tiņš'],
            // cyrillic
            ['собака', 'собака'],
            // non-ascii removals (should have been removed)
            ['ΓΔΣ', 'ΓΔΣ'],
            ['™ ⅓ ↵', '™ ⅓ ↵'],

            // weird one
//            ['‘‚†','‘‚†'],

            // all the replacements in one case
            [chr(226) . chr(128) . chr(152) . chr(226) . chr(128) . chr(153) . chr(226) . chr(128) . chr(156) . chr(226) . chr(128) . chr(157) . chr(226) . chr(128) . chr(147) . chr(226) . chr(128) . chr(148) . chr(226) . chr(128) . chr(162) . chr(194) . chr(183) . chr(226) . chr(128) . chr(166), "''\"\"--**..."],
        ];
    }

    /**
     * @dataProvider correctConvertAsciiDataProvider
     * @test
     */
    public function correctConvertAsciiTest($string, $expectation): void
    {
        $output = StringTool::convertAscii($string);
        self::assertSame($output, $expectation);
    }


    public function unaccentDataProvider()
    {
        return [
            ['', null],
            ['tiņš', null],
            ['собака', null],
            ['ΓΔΣ', null],
            ['™ ⅓ ↵', null],
        ];
    }

    /**
     * @dataProvider unaccentDataProvider
     * @test
     */
    public function correctUnaccentTest($string, $expectation): void
    {
        $output = StringTool::unaccent($string);
        self::assertSame($output, $expectation);
    }


    public function cleanSmsContentDataProvider()
    {
        return [
            ['', ''],
            ['tiņš', 'tins'],
            ['собака', 'sobaka'],
            ['ΓΔΣ', 'ΓΔΣ'],
            ['™ ⅓ ↵', '™ ⅓ ↵'],
        ];
    }

    /**
     * @dataProvider cleanSmsContentDataProvider
     * @test
     */
    public function correctCleanSmsContentTest($string, $expectation): void
    {
        $output = StringTool::cleanSmsContent($string);
        self::assertSame($output, $expectation);
    }


    public function getArrayWithRemovedPrefixRecursiveDataProvider()
    {
        return [
            [
                [
                    0 => 'durra',
                    1 => 'durr3',
                    2 => [
                        0 => 'durrstra',
                        1 => 'nope',
                        2 => [
                            0 => 'durtra',
                            1 => 'nope'
                        ],
                    ],
                    3 => 'bloopereeno',
                    4 => '123',
                ],
                'durr',
                [
                    0 => 'durra',
                    1 => 'durr3',
                    2 => [
                        0 => 'durrstra',
                        1 => 'nope',
                        2 => [
                            0 => 'durtra',
                            1 => 'nope'
                        ],
                    ],
                    3 => 'bloopereeno',
                    4 => '123',
                ],
            ],
            [
                [
                    'durr' => 'durra',
                    'durr2' => 'durr3',
                    'durr123' => [
                        0 => 'durrstra',
                        'Bloope' => 'nope',
                        'sdurr' => [
                            0 => 'durtra',
                            1 => 'nope'
                        ],
                    ],
                    3 => 'bloopereeno',
                    '123durr' => '123',
                ],
                'durr',
                [
                    '' => 'durra',
                    '2' => 'durr3',
                    '123' => [
                        0 => 'durrstra',
                        'Bloope' => 'nope',
                        'sdurr' => [
                            0 => 'durtra',
                            1 => 'nope'
                        ],
                    ],
                    3 => 'bloopereeno',
                    '123durr' => '123',
                ],
            ],
        ];
    }

    /**
     * @dataProvider getArrayWithRemovedPrefixRecursiveDataProvider
     * @test
     */
    public function correctGetArrayWithRemovedPrefixRecursiveTest($array, $prefix, $expectation): void
    {
        $output = StringTool::getArrayWithRemovedPrefixRecursive($array, $prefix);
        self::assertSame($output, $expectation);
    }


    public function createCombionationsFromStringWordsDataProvider()
    {
        return [
            ['', [0 => '']],
            ['dublin', [0 => 'dublin']],
            ['Dublin Prague', [0 => 'dublin prague', 1 => 'prague dublin']],
        ];
    }

    /**
     * @dataProvider createCombionationsFromStringWordsDataProvider
     * @test
     */
    public function createCombionationsFromStringWordsTest($phrase, $expectation): void
    {
        $output = StringTool::createCombionationsFromStringWords($phrase);
        self::assertSame($output, $expectation);
    }


    public function createCombionationsFromWordsDataProvider()
    {
        return [
            [[], [0 => '']],
            [
                ['pyke', 'trebuchet'],
                [
                    0 => 'pyke trebuchet',
                    1 => 'trebuchet pyke',
                ]
            ],
            [
                ['1', 'port', 'table'],
                [
                    0 => '1 port table',
                    1 => 'port 1 table',
                    2 => '1 table port',
                    3 => 'table 1 port',
                    4 => 'port table 1',
                    5 => 'table port 1',
                ]
            ],
        ];
    }

    /**
     * @dataProvider createCombionationsFromWordsDataProvider
     * @test
     */
    public function correctCreateCombionationsFromWordsTest($array, $expectation): void
    {
        $output = StringTool::createCombionationsFromWords($array);
        self::assertSame($output, $expectation);
    }


    public function toLowerDataProvider()
    {
        return [
            ['', ''],
            ['Abc', 'abc'],
            ['AAA', 'aaa'],
            ['AAA%%', 'aaa%%'],
        ];
    }

    /**
     * @dataProvider toLowerDataProvider
     * @test
     */
    public function correctToLowerTest($string, $expectation): void
    {
        $output = StringTool::toLower($string);
        self::assertSame($output, $expectation);
    }


    public function toUpperDataProvider()
    {
        return [
            ['', ''],
            ['Abc', 'ABC'],
            ['Aaa', 'AAA'],
            ['Aaa%%', 'AAA%%'],
        ];
    }

    /**
     * @dataProvider toUpperDataProvider
     * @test
     */
    public function correctToUpperTest($string, $expectation): void
    {
        $output = StringTool::toUpper($string);
        self::assertSame($output, $expectation);
    }


    public function toUTF8DataProvider()
    {
        return [
            ['', ''],
            ['Abc', 'Abc'],
            ['Aaa', 'Aaa'],
            ['Aaa%%ĀĀ§Ä±', 'Aaa%%ĀĀ§Ä±'],
        ];
    }

    /**
     * @dataProvider toUTF8DataProvider
     * @test
     */
    public function correctToUTF8Test($string, $expectation): void
    {
        $output = StringTool::toUTF8($string);
        self::assertSame($output, $expectation);
    }


    public function randomDataProvider()
    {
        return [
            ['1', '1'],
            ['20', '20'],
            ['1234', '1234'],
        ];
    }

    /**
     * @dataProvider randomDataProvider
     * @test
     */
    public function correctRandomTest($string, $expectation): void
    {
        $output = StringTool::random($string);
        self::assertEquals(strlen($output), $expectation);
    }


    public function passwordDataProvider()
    {
        return [
            ['8', '8'],
            ['20', '20'],
            ['1234', '1234'],
        ];
    }

    /**
     * @dataProvider passwordDataProvider
     * @test
     */
    public function correctPasswordTest($string, $expectation): void
    {
        $output = StringTool::password($string);
        self::assertEquals(strlen($output), $expectation);
    }


    public function polishToLatinDataProvider()
    {
        return [
            ['', ''],
            ['ĄĆĘŁÓŚŹŻŃąćęłóśźżń', 'ACELOSZZNaceloszzn'],
        ];
    }

    /**
     * @dataProvider polishToLatinDataProvider
     * @test
     */
    public function correctPolishToLatinTest($string, $expectation): void
    {
        $output = StringTool::polishToLatin($string);
        self::assertSame($output, $expectation);
    }


    public function cleanupPriceStringDataProvider()
    {
        return [
            ['2000 EUR', '2000.00'],
            ['2000.00', '2000.00'],
            ['2,000 EUR', '2000.00'],
            ['2.000', '2000.00'],
            ['2.320,34 EUR', '2320.34'],
            ['2,000,000.31', '2000000.31'],
            ['2.000.000', '2000000.00'],
            ['2.00', '2.00'],
            ['2,000€', '2000.00'],
        ];
    }

    /**
     * @dataProvider cleanupPriceStringDataProvider
     * @test
     */
    public function correctCleanupPriceStringTest($string, $expectation): void
    {
        $output = StringTool::cleanupPriceString($string);
        self::assertSame($output, $expectation);
    }

}
