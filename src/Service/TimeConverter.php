<?php

namespace Spikefalcon\TrackConverter\Service;

use Spikefalcon\TrackConverter\Entity\Enum\TimePointEnum;
use Spikefalcon\TrackConverter\Entity\Regex;
use Spikefalcon\TrackConverter\Entity\Time;
use Spikefalcon\TrackConverter\Pattern\TimePattern;

class TimeConverter
{
    const SECONDS_IN_HOUR = 3600;
    const SECONDS_IN_MINUTE = 60;
    const MILLISECONDS_IN_HOUR = 3600000;
    const MILLISECONDS_IN_MINUTE = 60000;
    const MILLISECONDS_IN_SECOND = 1000;

    /**
     * This function can be used to sort times against one another
     * This function is only precise to hundredths of a second
     * @param string $timeString
     * @return int
     */
    public static function timeStringToMilliSeconds($timeString)
    {
        $timeParts = RegexParser::parse(new Regex(TimePattern::getPattern()), $timeString);
        $seconds = 0;
        if (array_key_exists(0, $timeParts)) {
            if (array_key_exists(TimePointEnum::HOUR, $timeParts[0]) && is_numeric($timeParts[0][TimePointEnum::HOUR])) {
                $seconds += $timeParts[0][TimePointEnum::HOUR] * self::SECONDS_IN_HOUR * self::MILLISECONDS_IN_SECOND;
            }
            if (array_key_exists(TimePointEnum::MINUTE, $timeParts[0]) && is_numeric($timeParts[0][TimePointEnum::MINUTE])) {
                $seconds += $timeParts[0][TimePointEnum::MINUTE] * self::SECONDS_IN_MINUTE * self::MILLISECONDS_IN_SECOND;
            }
            if (array_key_exists(TimePointEnum::SECOND, $timeParts[0]) && is_numeric($timeParts[0][TimePointEnum::SECOND])) {
                $seconds += $timeParts[0][TimePointEnum::SECOND] * self::MILLISECONDS_IN_SECOND;
            }
            if (array_key_exists(TimePointEnum::FRACTION, $timeParts[0]) && is_numeric($timeParts[0][TimePointEnum::FRACTION])) {
                if (strlen($timeParts[0][TimePointEnum::FRACTION]) == 1) {
                    $seconds += $timeParts[0][TimePointEnum::FRACTION] *= 100;
                } else if (strlen($timeParts[0][TimePointEnum::FRACTION]) == 2) {
                    $seconds += $timeParts[0][TimePointEnum::FRACTION] *= 10;
                } else if (strlen($timeParts[0][TimePointEnum::FRACTION]) == 3) {
                    $seconds += $timeParts[0][TimePointEnum::FRACTION];
                } else if (strlen($timeParts[0][TimePointEnum::FRACTION]) > 3) {
                    $seconds += $timeParts[0][TimePointEnum::FRACTION] = (int) substr((string) $timeParts[0][TimePointEnum::FRACTION], 0, 3);
                }
            }
        }

        return $seconds;
    }

    /**
     * @param int $milliseconds
     * @return string
     */
    public static function millisecondsToTimeString($milliseconds)
    {
        return self::millisecondsToTime($milliseconds)->__toString();
    }

    /**
     * @param int $milliseconds
     * @return Time
     */
    protected static function millisecondsToTime($milliseconds)
    {
        $time = new Time();

        if ($milliseconds == 0) {
            return $time;
        }

        if (intdiv($milliseconds, self::MILLISECONDS_IN_HOUR) >= 1) {
            $time->setHour(intdiv($milliseconds, self::MILLISECONDS_IN_HOUR));
            $milliseconds -= (intdiv($milliseconds, self::MILLISECONDS_IN_HOUR) * self::MILLISECONDS_IN_HOUR);
        }

        if (intdiv($milliseconds, self::MILLISECONDS_IN_MINUTE) >= 1) {
            $time->setMinute(intdiv($milliseconds, self::MILLISECONDS_IN_MINUTE));
            $milliseconds -= (intdiv($milliseconds, self::MILLISECONDS_IN_MINUTE) * self::MILLISECONDS_IN_MINUTE);
        }

        if ($milliseconds >= self::MILLISECONDS_IN_SECOND) {
            $time->setSecond(intdiv($milliseconds, self::MILLISECONDS_IN_SECOND));
            $milliseconds -= (intdiv($milliseconds, self::MILLISECONDS_IN_SECOND) * self::MILLISECONDS_IN_SECOND);
        }

        if ($milliseconds > 0) {

            // If milliseconds are in the thousandths, we must round up to the nearest 100th
            if ($milliseconds >= 100) {
                $milliseconds = ceil($milliseconds / 10) * 10;
            }
            // Pass to function as hundredths of a second
            $time->setFraction($milliseconds / 10);
        }

        return $time;
    }
}
