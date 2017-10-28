<?php

use PHPUnit\Framework\TestCase;
use Spikefalcon\TrackConverter\Service\MetricMarkConverter;

/**
 * Class MetricMarkConverterTest
 *
 * @covers MetricMarkConverter
 */
class MetricMarkConverterTest extends TestCase
{
    /**
     * @param string $markString
     * @param int    $micrometers
     * @group        trackConverter
     * @group        markConverter
     * @covers       MetricMarkConverter::micrometersToMarkString
     * @dataProvider markToMicrometersProvider
     */
    public function testMillisecondsToTimeString($markString, $micrometers)
    {
        $this->assertEquals(
            $markString,
            MetricMarkConverter::micrometersToMarkString($micrometers)
        );
    }

    public function markToMicrometersProvider()
    {
        return [
            'fraction only' => [
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
        ];
    }

}
