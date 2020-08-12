<?php

namespace Marek\DateUtilities;

use DateTimeInterface;
use Carbon\Carbon;
use OutOfRangeException;

final class DateUtilities
{
    /**
     * @param \DateTimeInterface $date
     *
     * @return \DateTimeInterface
     *
     * @throws \Exception
     */
    public static function getStartOfTheDay(DateTimeInterface $date): DateTimeInterface
    {
        $current = new Carbon($date);
        $current->startOfDay();

        return $current->toDateTimeImmutable();
    }

    /**
     * @param \DateTimeInterface $date
     *
     * @return \DateTimeInterface
     *
     * @throws \Exception
     */
    public static function getEndOfTheDay(DateTimeInterface $date): DateTimeInterface
    {
        $current = new Carbon($date);
        $current->endOfDay();

        return $current->toDateTimeImmutable();
    }

    /**
     * Checks if $target is in the same week as $current
     *
     * @param \DateTimeInterface $current
     * @param \DateTimeInterface $target
     * @param int $startOfWeek
     * @param int $endOfWeek
     *
     * @return bool
     *
     * @throws \Exception
     */
    public static function isInCurrentWeek(DateTimeInterface $current, DateTimeInterface $target, int $startOfWeek = Weekday::MONDAY, int $endOfWeek = Weekday::SUNDAY): bool
    {
        static::validate($startOfWeek);
        static::validate($endOfWeek);

        $current = new Carbon($current);
        $givenDate = new Carbon($target);

        return $current->greaterThanOrEqualTo($givenDate->startOf('week', $startOfWeek))
            && $current->lessThanOrEqualTo($givenDate->endOfWeek($endOfWeek));
    }

    /**
     * Checks if $target is in the same week as $current
     *
     * @param \DateTimeInterface $current
     * @param \DateTimeInterface $dateTime
     *
     * @return bool
     *
     * @throws \Exception
     */
    public static function isInCurrentMonth(DateTimeInterface $current, DateTimeInterface $target): bool
    {
        $current = new Carbon($current);
        $givenDate = new Carbon($target);

        return $current->greaterThanOrEqualTo($givenDate->startOfMonth())
            && $current->lessThanOrEqualTo($givenDate->endOfMonth());
    }

    /**
     * Checks if $current is in the interval between $start and $end
     *
     * @param \DateTimeInterface $current
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     *
     * @return bool
     *
     * @throws \Exception
     */
    public static function isInCurrentDateInterval(DateTimeInterface $current, DateTimeInterface $start, DateTimeInterface $end): bool
    {
        $current = new Carbon($current);
        $start = new Carbon($start);
        $end = new Carbon($end);

        return $current->greaterThanOrEqualTo($start)
            && $current->lessThanOrEqualTo($end);
    }

    private static function validate(int $input): void
    {
        if (!in_array($input, Weekday::getWeekdays())) {
            throw new OutOfRangeException("Please provide a valid Weekday.");
        }
    }
}
