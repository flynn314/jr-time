<?php
namespace Tests;

use Flynn314\DateTime\JrTime;
use PHPUnit\Framework\TestCase;

/**
 * vendor/bin/phpunit tests/JrTimeTest.php
 */
class JrTimeTest extends TestCase
{
    private JrTime $jrTime;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->jrTime = new JrTime();
    }

    /**
     * @dataProvider dateProvider
     */
    public function testCase(string $expected, int $seconds, ?int $dayLength = null): void
    {
        if ($dayLength) {
            $this->assertEquals($expected, $this->jrTime->formatWithCustomDayLength($seconds, $dayLength));
        } else {
            $this->assertEquals($expected, $this->jrTime->format($seconds));
        }
    }

    public function testFormat(): void
    {
        $this->assertEquals('', $this->jrTime->format(0, ' '));
        $this->assertEquals('1d 1s', $this->jrTime->format(60 * 60 * 24 + 1, ' '));
    }

    public function testSimple(): void
    {
        $this->assertEquals('', $this->jrTime->formatSimple(0));
        $this->assertEquals('59s', $this->jrTime->formatSimple(59));
        $this->assertEquals('1d', $this->jrTime->formatSimple(60 * 60 * 24 + 1));
        $this->assertEquals('1d', $this->jrTime->formatSimple(60 * 60 * 24 + 60));
        $this->assertEquals('1y', $this->jrTime->formatSimple(60 * 60 * 24 * 366));
    }

    public function testSimpleExtended(): void
    {
        $this->assertEquals('', $this->jrTime->formatDuo(0, ' '));
        $this->assertEquals('59s', $this->jrTime->formatDuo(59, ' '));
        $this->assertEquals('1d 1s', $this->jrTime->formatDuo(60 * 60 * 24 + 1, ' '));
        $this->assertEquals('1d 1m', $this->jrTime->formatDuo(60 * 60 * 24 + 64, ' '));
        $this->assertEquals('1y 1d', $this->jrTime->formatDuo(60 * 60 * 24 * 366 + 119, ' '));
    }

    public function testFunction(): void
    {
        $this->assertEquals('59s', secondsToJrTime(59));
    }

    public static function dateProvider(): array
    {
        return [
            ['', 0],
            ['1s', 1],
            ['59s', 59],
            ['1m', 60],
            ['1h', 60 * 60],
            ['7h', 60 * 60 * 7],
            ['8h', 60 * 60 * 8],
            ['1d', 60 * 60 * 24],
            ['1d1s', 60 * 60 * 24 + 1],
            ['1d1m', 60 * 60 * 24 + 60],
            ['2d', 60 * 60 * 24 * 2],
            ['1w', 60 * 60 * 24 * 7],
            ['2w', 60 * 60 * 24 * 14],
            ['4w2d', 60 * 60 * 24 * 30],
            ['1y', 60 * 60 * 24 * 365],
            ['1y1d', 60 * 60 * 24 * 366],
            ['1y1d4h1m59s', 60 * 60 * 24 * 366 + 14400 + 119],
            ['1y2w1d4h1m59s', 60 * 60 * 24 * 366 + 14400 + 119 + (60 * 60 * 24 * 14)],

            ['1s', 1, 8],
            ['59s', 59, 8],
            ['1m', 60, 8],
            ['7h', 60 * 60 * 7, 8],
            ['7h59m', 60 * 60 * 7 + (59 * 60), 8],
            ['1d', 60 * 60 * 8, 8],
            ['2d', 60 * 60 * 8 * 2, 8],
            ['2w', 60 * 60 * 8 * 14, 8],

            ['8h', 60 * 60 * 8, 24],
            ['8h', 60 * 60 * 8],
        ];
    }
}
