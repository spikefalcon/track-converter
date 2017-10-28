<?php

namespace Spikefalcon\TrackConverter\Service;

use Spikefalcon\TrackConverter\Entity\Regex;

/**
 * Class RegexParser
 *
 * @package BennyT\HytekBundle\Service\Parser
 */
class RegexParser
{
    /**
     * Globally match the regular expression against the subject
     *
     * @param Regex $regex The regular expression to match against
     * @param string $subject The subject of the regular expression
     * @return array
     */
    public static function parse(Regex $regex, $subject)
    {
        $formattedRegex = $regex->getFormattedRegex();

        preg_match_all($formattedRegex, $subject, $matches, PREG_SET_ORDER);

        return $matches;
    }
}
