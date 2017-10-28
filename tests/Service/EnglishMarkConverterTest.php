<?php

use PHPUnit\Framework\TestCase;
use Spikefalcon\TrackConverter\Service\EnglishMarkConverter;

/**
 * Class EnglishMarkConverterTest
 *
 * @covers EnglishMarkConverter
 */
class EnglishMarkConverterTest extends TestCase
{
    /**
     * @param string $markString
     * @param int    $micrometers
     * @group        trackConverter
     * @group        markConverter
     * @covers       EnglishMarkConverter::micrometersToMarkString
     * @dataProvider markToMicrometersProvider
     */
    public function testMillisecondsToTimeString($markString, $micrometers)
    {
        $this->assertEquals(
            $markString,
            EnglishMarkConverter::micrometersToMarkString($micrometers)
        );
    }

    public function markToMicrometersProvider()
    {
        return [
            'fraction only' => [
                '0.25',
                6350
            ],
            'high jump' => [
                '4-10.00',
                1473200
            ],
            'feet without fraction' => [
                '11-00.00',
                3352800
            ],
            'feet with fraction' => [
                '11-00.25',
                3359150
            ],
            'feet with .5 fraction' => [
                '11-09.50',
                3594100
            ],
            'feet with .75 fraction' => [
                '11-03.75',
                3448050
            ],
            'feet and inches without fraction' => [
                '11-06.00',
                3505200
            ],
            'feet and inches with fraction' => [
                '11-06.25',
                3511550
            ],
            'feet and inches with non standard fraction' => [
                '11-06.08',
                3507232
            ],
        ];
    }

}
