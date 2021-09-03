<?php

namespace Common\Tool;

/**
 * Utility for financial calculations
 */
class NumberTool
{
    protected const SCALE = 10;

    /**
     * Convert numeric variable to string with right formatting
     * @param mixed $s
     * @return string
     */
    private static function f($s)
    {
        return sprintf('%.' . self::SCALE . 'f', $s);
    }

    /**
     * Performs addition
     * NumberTool::add('2.71', '3.18') //5.89
     * @param string $op1
     * @param string $op2
     * @param boolean $round
     * @return string
     */
    public static function add($op1, $op2, $round = true)
    {
        $res = bcadd(self::f($op1), self::f($op2), self::SCALE);
        return $round ? self::round($res) : $res;
    }

    /**
     * Performs substraction
     * NumberTool::sub('5.89', '3.18') //2.71
     * @param string $op1
     * @param string $op2
     * @param boolean $round
     * @return string
     */
    public static function sub($op1, $op2, $round = true)
    {
        $res = bcsub(self::f($op1), self::f($op2), self::SCALE);
        return $round ? self::round($res) : $res;
    }

    /**
     * Performs multiplication
     * NumberTool::mul('16.69', '12.47') //208.12
     * @param string $op1
     * @param string $op2
     * @param boolean $round
     * @return string
     */
    public static function mul($op1, $op2, $round = true)
    {
        $res = bcmul(self::f($op1), self::f($op2), self::SCALE);
        return $round ? self::round($res) : $res;
    }

    /**
     * Performs division
     * NumberTool::div('208.12', '16.69') //12.47
     * @param string $op1
     * @param string $op2
     * @param boolean $round
     * @return string
     */
    public static function div($op1, $op2, $round = true)
    {
        $res = bcdiv(self::f($op1), self::f($op2), self::SCALE);
        return $round ? self::round($res) : $res;
    }

    /**
     * Rise $left to $right
     * @param string $left left operand
     * @param string $right right operand
     * @param boolean $round
     * @return string|float|int
     */
    public static function pow($left, $right, $round = true)
    {
        //bcpow does not support decimal numbers
        $res = $left ** $right;
        return $round ? self::round($res) : $res;
    }

    /**
     * Truncates decimal number to given precision
     * NumberTool::truncate('1.9999', 2) //1.99
     * @param string $number
     * @param integer $precision
     * @return string
     */
    public static function truncate($number, $precision)
    {
        $x = explode('.', $number);
        if (count($x) === 1) {
            return $x[0];
        }
        if ($precision === 0) {
            return $x[0];
        }
        return $x[0] . '.' . substr($x[1], 0, $precision);
    }

    /**
     * Absolute number value
     * NumberTool::abs('-10.99') //10.99
     * @param string $number
     * @return string
     */
    public static function abs($number)
    {
        $number = self::f($number);
        if ($number === '') {
            return $number;
        }

        if ($number[0] !== '-') {
            return $number;
        }

        return substr($number, 1);
    }

    /**
     * Rounds number with precision of $precision decimal places
     * NumberTool::round('208.1243') //208.12
     * @param string|int|float $val
     * @param integer $precision
     * @return string
     */
    public static function round($val, int $precision = 2): string
    {
        return number_format(round($val, $precision), $precision, '.', '');
    }

    /**
     * Formats number to decimal
     *
     * @param string $val
     * @param integer $precision
     * @return string
     */
    public static function format($val, $precision = 2)
    {
        return number_format($val, $precision, '.', '');
    }

    /**
     * Rounds down number with precision of $precision decimal places
     * NumberTool::roundDown('2.03717') //2.03
     * @param string $val
     * @param integer $precision
     * @return string
     */
    public static function roundDown($val, $precision = 2)
    {
        if (self::isZero($val)) {
            return self::round($val, $precision);
        }

        $half = 0.5 / (10 ** $precision);
        return number_format(round($val - $half, $precision), $precision, '.', '');
    }

    /**
     * Floor
     * @param string $val
     * @return string
     */
    public static function floor($val)
    {
        return self::truncate($val, 0);
    }

    /**
     * Rounds number with custom precision and custom format
     * Example: NumberTool::round('208.1243', 2) // 208.12
     *
     * @access public
     * @param numeric $val
     * @param int $precision
     * @return string
     */
    public static function roundCustom($val, int $precision = 1): string
    {
        return self::round($val, $precision);
    }

    /**
     * Calculates percentage
     * NumberTool::percent('19.99', '21.00') //4.20
     * @param string $amount
     * @param string $percentage
     * @param boolean $round
     * @return string
     */
    public static function percent($amount, $percentage, $round = true)
    {
        $res = bcmul(self::f($amount), bcdiv(self::f($percentage), '100', self::SCALE), self::SCALE);
        return $round ? self::round($res) : $res;
    }

    /**
     * NumberTool::addPercent('19.99', '21.00') //24.19
     * @param string $amount
     * @param string $percentage
     * @return string
     */
    public static function addPercent($amount, $percentage, $round = true)
    {
        $res = bcadd(self::f($amount), self::percent(self::f($amount), self::f($percentage)), self::SCALE);
        return $round ? self::round($res) : $res;
    }

    /**
     * NumberTool::beforePercentAddition('24.19', '21.00') //19.99
     * @param string $result
     * @param string $percentage
     * @return string
     */
    public static function beforePercentAddition($result, $percentage, $round = true)
    {
        $res = bcmul(bcdiv($result, bcadd($percentage, '100', self::SCALE), self::SCALE), '100', self::SCALE);

        return $round ? self::round($res) : $res;
    }

    public static function addVat($value, $percentage)
    {
        return self::addPercent($value, $percentage);
    }

    public static function removeVat($total, $percentage)
    {
        return self::beforePercentAddition($total, $percentage);
    }

    public static function vatAmount($total, $percentage): string
    {
        $withoutVat = self::beforePercentAddition($total, $percentage, false);
        return self::percent($withoutVat, $percentage);
    }

    public static function isNullOrZero($number): bool
    {
        return $number === null || self::isZero($number);
    }

    public static function isZero($number): bool
    {
        return (float)$number === .0;
    }

    /**
     * Performs addition to all passed arguments
     * NumberTool::add('1.00', '2.00', '3.00') //6.00
     * @param string $op1
     * @param string $op2
     * @param boolean $round
     * @return string
     */
    public static function addAll()
    {
        $res = '0.00';
        foreach (func_get_args() as $arg) {
            $res = self::add($res, $arg);
        }
        return $res;
    }

    /**
     * Returns true if $left is greater than $right
     * @param string $left left operand
     * @param string $right right operand
     * @return bool
     */
    public static function gt($left, $right): bool
    {
        return bccomp(self::f($left), self::f($right), self::SCALE) === 1;
    }

    /**
     * Returns true if $left is greater than or equal to $right
     * @param string $left left operand
     * @param string $right right operand
     * @return bool
     */
    public static function gte($left, $right): bool
    {
        $comp = bccomp(self::f($left), self::f($right), self::SCALE);
        return $comp === 0 || $comp === 1;
    }

    /**
     * Returns true if $left is smaller than $right
     * @param string $left left operand
     * @param string $right right operand
     * @return bool
     */
    public static function lt($left, $right): bool
    {
        return bccomp(self::f($left), self::f($right), self::SCALE) === -1;
    }

    /**
     * Returns true if $left is smaller than or equal to $right
     * @param mixed $left left operand
     * @param mixed $right right operand
     * @return bool
     */
    public static function lte($left, $right): bool
    {
        $comp = bccomp(self::f($left), self::f($right), self::SCALE);
        return $comp === 0 || $comp === -1;
    }

    /**
     * Returns true if $left is equal to $right
     * @param string $left left operand
     * @param string $right right operand
     * @return bool
     */
    public static function eq($left, $right): bool
    {
        return bccomp(self::f($left), self::f($right), self::SCALE) === 0;
    }

    /**
     * PHP Version of PMT in Excel.
     *
     * @param float $apr
     *   Interest rate.
     * @param integer $term
     *   Loan length in months.
     * @param float $loan
     *   The loan amount.
     *
     * @return float
     *   The monthly mortgage amount.
     */
    public static function pmt($apr, $term, $loan): float
    {
        $apr = $apr / 1200;
        $amount = $apr * -$loan * ((1 + $apr) ** $term) / (1 - ((1 + $apr) ** $term));
        return number_format($amount, 2);
    }

    /**
     * Calculate median value by array values.
     *
     * @access public
     * @param array $values
     * @param boolean $round
     * @return float|string
     */
    public static function calculateMedian($values, $round = true)
    {
        $count = count($values); // total numbers in array
        $middleval = floor(($count - 1) / 2); // find the middle value, or the lowest middle value

        if ($count % 2) { // odd number, middle is the median
            $median = $values[$middleval];
        } else { // even number, calculate avg of 2 medians
            $low = $values[$middleval];
            $high = $values[$middleval + 1];
            $median = (($low + $high) / 2);
        }

        return $round ? self::round($median) : $median;
    }

    /**
     * Calculate average value by array values.
     *
     * @access public
     * @param array $values
     * @param boolean $round
     * @return float|string
     */
    public static function calculateAverage($values, $round = true)
    {
        $count = count($values); // total numbers in array

        $total = 0;
        foreach ($values as $value) {
            $total += $value; // total value of array numbers
        }
        $average = ($total / $count); // get average value

        return $round ? self::round($average) : $average;
    }

    public static function numberToText($number, $locale = null)
    {
        if (!$locale) {
            $locale = 'en';
        }

        $style = \NumberFormatter::SPELLOUT;
        $formatter = new \NumberFormatter($locale, $style);

        // Format
        $formatted = $formatter->format($number);

        // Remove soft hyphens
        $formatted = preg_replace('~\x{00AD}~u', '', $formatted);

        return $formatted;
    }

    /**
     * Returns rounded value and difference after rounding
     * @param mixed $value
     * @return array
     */
    public static function getRoundedValueAndDifference($value): array
    {
        $rounded = self::truncate($value, 2);
        $diff = self::sub($value, $rounded, false);

        return [
            'roundedValue' => $rounded,
            'diff' => $diff,
        ];
    }

    /**
     * @param float|int $total
     * @param float|int $partial
     * @return string
     */
    public static function getPercentageBetweenTwo($total, $partial): string
    {
        if (0 == $partial) {
            return '0';
        }

        return number_format(($partial / $total) * 100, 2);
    }

    /**
     * Usage:
     *   NumberTool::result('$1 + $2', $variable, $variableTwo)
     *   NumberTool::result('((1 + $1)^12 - 1) * 100', $variable)
     *
     * @param string $string
     * @return string
     */
    public static function result(string $string): string
    {
        bcscale(self::SCALE);

        $argv = func_get_args();
        $string = str_replace(' ', '', "({$string})");

        $operations = [];
        if (strpos($string, '^') !== false) {
            $operations[] = '\^';
        }
        if (strpbrk($string, '*/%') !== false) {
            $operations[] = '[\*\/\%]';
        }
        if (strpbrk($string, '+-') !== false) {
            $operations[] = '[\+\-]';
        }
        if (strpbrk($string, '<>!=') !== false) {
            $operations[] = '<|>|=|<=|==|>=|!=|<>';
        }

        $string = preg_replace_callback('/\$([0-9\.]+)/', function ($matches) use ($argv) {
            return $argv[$matches[1]];
        }, $string);

        while (preg_match('/\(([^\)\(]*)\)/', $string, $match)) {
            foreach ($operations as $operation) {
                if (preg_match("/([+-]{0,1}[0-9\.]+)($operation)([+-]{0,1}[0-9\.]+)/", $match[1], $m)) {
                    $result = self::getResult($m[1], $m[2], $m[3]);
                    $match[1] = str_replace($m[0], $result, $match[1]);
                }
            }
            $string = str_replace($match[0], $match[1], $string);
        }

        return $string;
    }

    private static function getResult($m1, string $operator, $m3)
    {
        $result = null;
        switch ($operator) {
            case '+':
                $result = bcadd($m1, $m3);
                break;
            case '-':
                $result = bcsub($m1, $m3);
                break;
            case '*':
                $result = bcmul($m1, $m3);
                break;
            case '/':
                $result = bcdiv($m1, $m3);
                break;
            case '%':
                $result = bcmod($m1, $m3);
                break;
            case '^':
                $result = bcpow($m1, $m3);
                break;
            case '==':
            case '=':
                $result = bccomp($m1, $m3) === 0;
                break;
            case '>':
                $result = bccomp($m1, $m3) === 1;
                break;
            case '<':
                $result = bccomp($m1, $m3) === -1;
                break;
            case '>=':
                $result = bccomp($m1, $m3) >= 0;
                break;
            case '<=':
                $result = bccomp($m1, $m3) <= 0;
                break;
            case '<>':
            case '!=':
                $result = bccomp($m1, $m3) != 0;
                break;
        }
        return $result;
    }
}
