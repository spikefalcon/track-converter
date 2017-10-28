<?php

namespace Spikefalcon\TrackConverter\Pattern;

use Spikefalcon\TrackConverter\Entity\Enum\TimePointEnum;

/**
 * Class TimePattern
 *
 * Generate a regular expression to obtain hours, minutes, seconds, and second fractions from time
 * eg. 21.45,
 *
 * @package BennyT\HytekDataBundle\Pattern
 */
class TimePattern
{
    /**
    /**
     * Return a regular expression pattern
     *
     * @return string
     */
    public static function getPattern()
    {
        return '((?:(?\'' . TimePointEnum::HOUR . '\'\d{1,2}):)(?=\d{1,2}:))?' .
        '(?:(?\'' . TimePointEnum::MINUTE . '\'\d{1,2}):)?' .
        '(?\'' . TimePointEnum::SECOND . '\'\d{1,2})' .
        '(?:.(?\'' . TimePointEnum::FRACTION . '\'\d{1,3}))?';
    }
}
