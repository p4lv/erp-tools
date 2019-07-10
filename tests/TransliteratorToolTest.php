<?php

namespace Common\Tool;

use PHPUnit\Framework\TestCase;

class TransliteratorToolTest extends TestCase
{
    public function correctUnaccentDataProvider()
    {
        $cyrillicString = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ';
        $latinizedCyrillicString = 'abvgdeezhziyklmnoprstufhtschshshtiyyeyuyaABVGDEEZhZIYKLMNOPRSTUFHTsChShShtIYYEYuYa';

        $defTransliteratedStringSource = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ';
        $defTransliteratedStringResult = 'AAAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlllNnNnNnnOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo';
        return [
            [null, '', ''],
            ['', true, ''],
            ['', false, ''],
            [1, true, '1'],
            [1, false, '1'],

            [$cyrillicString, false, $cyrillicString],
            [$cyrillicString, true, $latinizedCyrillicString],
            [$cyrillicString . $defTransliteratedStringSource, true, $latinizedCyrillicString . $defTransliteratedStringResult],
            [$cyrillicString . $defTransliteratedStringSource, false, $cyrillicString . $defTransliteratedStringResult],
        ];
    }

    /**
     * @test
     * @dataProvider correctUnaccentDataProvider
     */
    public function correctUnaccent($string, $transliterateCyrillic, $expectedResult)
    {
        $actualResult = Transliterator::unaccent($string, $transliterateCyrillic);
        self::assertSame($expectedResult, $actualResult);
    }
}
