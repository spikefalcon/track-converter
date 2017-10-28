<?php

use PHPUnit\Framework\TestCase;
use Spikefalcon\TrackConverter\Service\MarkConverter;

/**
 * Class MarkConverterTest
 *
 * @covers MarkConverter
 */
class MarkConverterTest extends TestCase
{
    /**
     * @param string $markString
     * @param int    $micrometers
     * @group        trackConverter
     * @group        markConverter
     * @covers       MarkConverter::micrometersToMarkString
     * @dataProvider markToMicrometersProvider
     */
    public function testMillisecondsToTimeString($markString, $micrometers)
    {
        $this->assertEquals(
            $micrometers,
            MarkConverter::markStringToMicrometers($markString)
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
            'metric fraction only' => [
                '0.25m',
                250000
            ],
            'one digit meter, fraction < 10' => [
                '1.09m',
                1090000
            ],
            'one digit meter, fraction > 10' => [
                '1.47m',
                1470000
            ],
            'two digit meter, fraction < 10' => [
                '11.09m',
                11090000
            ],
            'two digit meter, fraction > 10' => [
                '12.47m',
                12470000
            ],
            'three digit meter, fraction < 10' => [
                '101.09m',
                101090000
            ],
            'three digit meter, fraction > 10' => [
                '132.47m',
                132470000
            ],
            'Did not finish' => [
                'DNF',
                0
            ],
        ];
    }

}
