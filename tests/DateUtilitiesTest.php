<?php

namespace Marek\DateUtilities\Tests;

use Marek\DateUtilities\DateUtilities;
use DateTimeImmutable;
use Marek\DateUtilities\Weekday;
use PHPUnit\Framework\TestCase;

class DateUtilitiesTest extends TestCase
{
    /**
     * @dataProvider provideWeekDates
     */
    public function testWeek($current, $target, $startOfWeek, $endOfWeek, $result): void
    {
        $this->assertSame($result, DateUtilities::isInCurrentWeek($current, $target, $startOfWeek, $endOfWeek));
    }

    public function testInvalidWeekParams(): void
    {
        $this->expectException(\OutOfRangeException::class);
        DateUtilities::isInCurrentWeek(new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-09'), 15, Weekday::WEDNESDAY);
    }

    /**
     * @dataProvider provideMonthDates
     */
    public function testMonth($current, $target, $result): void
    {
        $this->assertSame($result, DateUtilities::isInCurrentMonth($current, $target));
    }

    /**
     * @dataProvider provideIntervals
     */
    public function testIntervals($current, $start, $end, $result): void
    {
        $this->assertSame($result, DateUtilities::isInCurrentDateInterval($current, $start, $end));
    }

    public function provideWeekDates(): array
    {
        return [
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-14'), Weekday::MONDAY, Weekday::SUNDAY, true],
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-10'), Weekday::MONDAY, Weekday::SUNDAY, true],
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-16'), Weekday::MONDAY, Weekday::SUNDAY, true],
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-17'), Weekday::MONDAY, Weekday::SUNDAY, false],
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-09'), Weekday::MONDAY, Weekday::SUNDAY, false],
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-09'), Weekday::SUNDAY, Weekday::SATURDAY, true],
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-16'), Weekday::SUNDAY, Weekday::SATURDAY, false],
            [new DateTimeImmutable('2020-08-10 23:59'), new DateTimeImmutable('2020-08-16 23:59'), Weekday::MONDAY, Weekday::SUNDAY, true],
            [new DateTimeImmutable('2020-08-09 23:59'), new DateTimeImmutable('2020-08-16 23:59'), Weekday::MONDAY, Weekday::SUNDAY, false],
        ];
    }

    public function provideMonthDates(): array
    {
        return [
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-14'), true],
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-01'), true],
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-31'), true],
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-09-17'), false],
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-07-09'), false],
        ];
    }

    public function provideIntervals(): array
    {
        return [
            [new DateTimeImmutable('2020-08-10'), new DateTimeImmutable('2020-08-15'), new DateTimeImmutable('2020-08-31'), false],
            [new DateTimeImmutable('2020-09-01'), new DateTimeImmutable('2020-08-15'), new DateTimeImmutable('2020-08-31'), false],
            [new DateTimeImmutable('2020-08-01'), new DateTimeImmutable('2020-08-01'), new DateTimeImmutable('2020-08-31'), true],
        ];
    }
}
