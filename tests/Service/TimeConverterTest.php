<?php

use PHPUnit\Framework\TestCase;
use Spikefalcon\TrackConverter\Service\TimeConverter;

/**
 * Class TimeConverterTest
 *
 * @covers TimeConverter
 */
class TimeConverterTest extends TestCase
{

    /**
     * @param string    $timeString
     * @param int|float $seconds
     * @group        trackConverter
     * @group        timeConverter
     * @covers       TimeConverter::timeStringToMilliSeconds
     * @dataProvider timeStringToMilliSecondsProvider
     */
    public function testTimeStringToMilliSeconds($timeString, $seconds)
    {
        $this->assertEquals(
            $seconds,
            TimeConverter::timeStringToMilliSeconds($timeString)
        );
    }

    /**
     * @return array
     */
    public function timeStringToMilliSecondsProvider()
    {
        return [
            'seconds > 10, fraction > 10' => [
                '22.78',
                22780
            ],
            'seconds > 10, fraction in milliseconds' => [
                '22.783',
                22783
            ],
            'seconds > 10, fraction in 10 ^ -4 seconds' => [
                '22.7832',
                22783
            ],
            'seconds > 10, fraction < 10' => [
                '22.09',
                22090
            ],
            'seconds > 10, 1 fraction digit' => [
                '22.5',
                22500
            ],
            'hours, minutes, seconds' => [
                '1:34:15',
                5655000
            ],
            'hours, minutes, seconds, fraction' => [
                '1:34:15.68',
                5655680
            ],
            'hours, minutes < 10, seconds < 10' => [
                '1:09:09',
                4149000
            ],
            'hours, minutes > 10, seconds > 10' => [
                '1:15:15',
                4515000
            ],
            'minutes < 10, seconds < 10' => [
                '09:09',
                549000
            ],
            'minutes < 10, seconds < 10, fraction < 10' => [
                '09:09.09',
                549090
            ],
            'minutes < 10, seconds < 10, , 1 fraction digit' => [
                '09:09.90',
                549900
            ],
        ];
    }

    /**
     * @param int    $milliseconds
     * @param string $timeString
     * @group        trackConverter
     * @group        timeConverter
     * @covers       TimeConverter::millisecondsToTimeString
     * @dataProvider millisecondsToTimeStringProvider
     */
    public function testMillisecondsToTimeString($milliseconds, $timeString)
    {
        $this->assertEquals(
            $timeString,
            TimeConverter::millisecondsToTimeString($milliseconds)
        );
    }

    public function millisecondsToTimeStringProvider()
    {
        return [
            'seconds only' => [
                22000,
                '22.00'
            ],
            'seconds and tenths' => [
                22200,
                '22.20'
            ],
            'seconds and hundredths < 10' => [
                22090,
                '22.09'
            ],
            'seconds and hundredths > 10' => [
                22580,
                '22.58'
            ],
            'seconds and thousandths, last digit 0' => [
                22580,
                '22.58'
            ],
            'seconds and thousandths, last digit > 0' => [
                22581,
                '22.59'
            ],
            '1 digit minute, 1 digit second' => [
                61000,
                '1:01.00'
            ],
            '2 digit minute' => [
                660000,
                '11:00.00'
            ],
            '2 digit minute, 1 digit second' => [
                604000,
                '10:04.00'
            ],
            '1 digit minute, 1 digit second, 1 hundredth' => [
                61010,
                '1:01.01'
            ],
            '1 digit minute, 1 digit second, 1 tenth' => [
                61200,
                '1:01.20'
            ],
            '2 digit minute, 1 digit second, 1 hundredth' => [
                601020,
                '10:01.02'
            ],
            '2 digit minute, 1 digit second, 1 tenth' => [
                601200,
                '10:01.20'
            ],
        ];
    }

}
