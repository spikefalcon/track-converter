<?php

namespace Spikefalcon\TrackConverter\Service;

use Spikefalcon\TrackConverter\Entity\Enum\MetricMarkEnum;
use Spikefalcon\TrackConverter\Entity\MetricMark;
use Spikefalcon\TrackConverter\Entity\Regex;
use Spikefalcon\TrackConverter\Pattern\MetricMarkPattern;

class MetricMarkConverter implements MarkConverterInterface
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
        $markParts = RegexParser::parse(new Regex(MetricMarkPattern::getPattern()), $markString);
        $micrometers = 0;

        if (array_key_exists(0, $markParts)) {
            if (array_key_exists(MetricMarkEnum::METER, $markParts[0]) && is_numeric($markParts[0][MetricMarkEnum::METER])) {
                $micrometers += $markParts[0][MetricMarkEnum::METER] * self::MICROMETERS_IN_METER;
            }
            if (array_key_exists(MetricMarkEnum::FRACTION, $markParts[0]) && is_numeric($markParts[0][MetricMarkEnum::FRACTION])) {
                $fraction = $markParts[0][MetricMarkEnum::FRACTION];
                if (strlen($markParts[0][MetricMarkEnum::FRACTION]) == 1) {
                    $fraction = $markParts[0][MetricMarkEnum::FRACTION] *= 10;
                } else if (strlen($markParts[0][MetricMarkEnum::FRACTION]) > 2) {
                    $fraction = $markParts[0][MetricMarkEnum::FRACTION] = (int) substr((string) $markParts[0][MetricMarkEnum::FRACTION], 0, 2);
                }
                $micrometers += ($fraction * .01) * self::MICROMETERS_IN_METER;
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
     * @return MetricMark
     */
    protected function micrometersToMark($micrometers)
    {
        $mark = new MetricMark();

        if ($micrometers == 0) {
            return $mark;
        }

        if (intdiv($micrometers, self::MICROMETERS_IN_METER) >= 1) {
            $mark->setMeter(intdiv($micrometers, self::MICROMETERS_IN_METER));
            $micrometers -= (intdiv($micrometers, self::MICROMETERS_IN_METER) * self::MICROMETERS_IN_METER);
        }

        if ($micrometers > 0) {
            // Pass to function as hundreths of a second
            $centimeters = $micrometers / self::MICROMETERS_IN_METER;
            $fraction = $centimeters * 100;
            $mark->setFraction($fraction);
        }

        return $mark;
    }
}
