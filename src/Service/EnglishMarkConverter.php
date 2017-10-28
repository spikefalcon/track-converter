<?php

namespace Spikefalcon\TrackConverter\Service;

use Spikefalcon\TrackConverter\Entity\Enum\EnglishMarkEnum;
use Spikefalcon\TrackConverter\Pattern\EnglishMarkPattern;
use Spikefalcon\TrackConverter\Entity\Regex;
use Spikefalcon\TrackConverter\Entity\EnglishMark;

class EnglishMarkConverter implements MarkConverterInterface
{
    const METERS_IN_FOOT = 0.3048;
    const METERS_IN_INCH = 0.0254;
    const MICROMETERS_IN_METER = 1000000;

    const MICROMETERS_IN_FOOT = 304800;
    const MICROMETERS_IN_INCH = 25400;
    const INCH_IN_MICROMETERS = 25400;

    /**
     * This function can be used to sort times against one another
     * This function is only precise to hundredths of a meter or inch
     * @param string $markString
     * @return int
     */
    public static function markStringToMicrometers($markString)
    {
        // Is english or metric
        $markParts = RegexParser::parse(new Regex(EnglishMarkPattern::getPattern()), $markString);
        $micrometers = 0;

        if (array_key_exists(0, $markParts)) {
            if (array_key_exists(EnglishMarkEnum::FOOT, $markParts[0]) && is_numeric($markParts[0][EnglishMarkEnum::FOOT])) {
                $micrometers += $markParts[0][EnglishMarkEnum::FOOT] * self::METERS_IN_FOOT * self::MICROMETERS_IN_METER;
            }
            if (array_key_exists(EnglishMarkEnum::INCH, $markParts[0]) && is_numeric($markParts[0][EnglishMarkEnum::INCH])) {
                $micrometers += $markParts[0][EnglishMarkEnum::INCH] * self::METERS_IN_INCH * self::MICROMETERS_IN_METER;
            }
            if (array_key_exists(EnglishMarkEnum::FRACTION, $markParts[0]) && is_numeric($markParts[0][EnglishMarkEnum::FRACTION])) {
                $fraction = $markParts[0][EnglishMarkEnum::FRACTION];
                if (strlen($markParts[0][EnglishMarkEnum::FRACTION]) == 1) {
                    $fraction = $markParts[0][EnglishMarkEnum::FRACTION] *= 10;
                } else if (strlen($markParts[0][EnglishMarkEnum::FRACTION]) > 2) {
                    $fraction = $markParts[0][EnglishMarkEnum::FRACTION] = (int) substr((string) $markParts[0][EnglishMarkEnum::FRACTION], 0, 2);
                }
                $micrometers += ($fraction * .01) * self::METERS_IN_INCH * self::MICROMETERS_IN_METER;
            }
        }

        return $micrometers;
    }

    /**
     * @param int $micrometers
     * @return string
     */
    public static function micrometersToMarkString($micrometers)
    {
        return self::micrometersToMark($micrometers)->__toString();
    }

    /**
     * @param int $micrometers
     * @return EnglishMark
     */
    protected static function micrometersToMark($micrometers)
    {
        $mark = new EnglishMark();

        if ($micrometers == 0) {
            return $mark;
        }

        if (intdiv($micrometers, self::MICROMETERS_IN_FOOT) >= 1) {
            $mark->setFoot(intdiv($micrometers, self::MICROMETERS_IN_FOOT));
            $micrometers -= (intdiv($micrometers, self::MICROMETERS_IN_FOOT) * self::MICROMETERS_IN_FOOT);
        }

        if ($micrometers >= self::MICROMETERS_IN_INCH) {
            $mark->setInch(intdiv($micrometers, self::MICROMETERS_IN_INCH));
            $micrometers -= (intdiv($micrometers, self::MICROMETERS_IN_INCH) * self::MICROMETERS_IN_INCH);
        }

        if ($micrometers > 0) {
            // Pass to function as hundreths of a second
            $inches = $micrometers / self::MICROMETERS_IN_INCH;
            $fraction = $inches * 100;
            $mark->setFraction($fraction);
        }

        return $mark;
    }
}
