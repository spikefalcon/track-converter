<?php

namespace Spikefalcon\TrackConverter\Service;

use Spikefalcon\TrackConverter\Pattern\EnglishMarkPattern;
use Spikefalcon\TrackConverter\Pattern\MetricMarkPattern;
use Spikefalcon\TrackConverter\Entity\Regex;

class MarkConverter implements MarkConverterInterface
{
    /**
     * This function can be used to sort times against one another
     * This function is only precise to hundredths of a meter or inch
     * @param string $markString
     *
     * @return int
     */
    public static function markStringToMicrometers($markString)
    {
        $metricMarkParts = RegexParser::parse(new Regex(MetricMarkPattern::getPattern()), $markString);
        if (array_key_exists(0, $metricMarkParts)) {
            return MetricMarkConverter::markStringToMicrometers($markString);
        }

        $englishMarkParts = RegexParser::parse(new Regex(EnglishMarkPattern::getPattern()), $markString);
        if (array_key_exists(0, $englishMarkParts)) {
            return EnglishMarkConverter::markStringToMicrometers($markString);
        }

        return 0;
    }

    /**
     * Return micrometers in English
     * TODO: Set to Meet default
     * @param int $micrometers
     * @return string
     */
    public static function micrometersToMarkString($micrometers)
    {
        return EnglishMarkConverter::micrometersToMarkString($micrometers);
    }
}
