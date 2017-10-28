<?php

namespace Spikefalcon\TrackConverter\Pattern;

use Spikefalcon\TrackConverter\Entity\Enum\EnglishMarkEnum;

/**
 * Class EnglishMarkPattern
 *
 * Generate a regular expression to obtain feet, inches, and inch fractions
 * e.g. 21-07.45, 119-01, 0.25
 *
 * @package Spikefalcon\TrackConverter\Pattern
 */
class EnglishMarkPattern
{
    /**
    /**
     * Return a regular expression pattern
     *
     * @return string
     */
    public static function getPattern()
    {
        return '(?:(?\'' . EnglishMarkEnum::FOOT . '\'\d{1,4})-)?' .
        '(?\'' . EnglishMarkEnum::INCH . '\'\d{1,2})' .
        '(?:.(?\'' . EnglishMarkEnum::FRACTION . '\'\d{1,2}))?';
    }
}
