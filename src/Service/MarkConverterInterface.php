<?php

namespace Spikefalcon\TrackConverter\Service;

interface MarkConverterInterface
{
    /**
     * This function can be used to sort times against one another
     * This function is only precise to hundredths of a meter or inch
     * @param string $markString
     * @return int
     */
    public static function markStringToMicrometers($markString);

    /**
     * @param int $micrometers
     * @return string
     */
    public static function micrometersToMarkString($micrometers);
}