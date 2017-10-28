<?php

namespace Spikefalcon\TrackConverter\Pattern;

use Spikefalcon\TrackConverter\Entity\Enum\MetricMarkEnum;

/**
 * Class EnglishMarkPattern
 *
 * Generate a regular expression to obtain meters and metric fractions
 * e.g. 0.25m, 3.45m, 74.89m
 *
 * @package Spikefalcon\TrackConverter\Pattern
 */
class MetricMarkPattern
{
    /**
    /**
     * Return a regular expression pattern
     *
     * @return string
     */
    public static function getPattern()
    {
        return '(?:(?\'' . MetricMarkEnum::METER . '\'\d{1,4}))' .
        '(?:.(?\'' . MetricMarkEnum::FRACTION . '\'\d{1,2}))?m';
    }
}
