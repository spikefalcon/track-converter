<?php

namespace Spikefalcon\TrackConverter\Entity;

class Time
{
    /** @var int $hour */
    protected $hour;

    /** @var int $minute */
    protected $minute;

    /** @var int $second */
    protected $second;

    /** @var int $fraction */
    protected $fraction;

    /**
     * Time constructor.
     */
    public function __construct()
    {
        $this->hour = 0;
        $this->minute = 0;
        $this->second = 0;
        $this->fraction = 0;
    }

    /**
     * @return int
     */
    public function getHour(): int
    {
        return $this->hour;
    }

    /**
     * @param int $hour
     */
    public function setHour(int $hour)
    {
        $this->hour = $hour;
    }

    /**
     * @return int
     */
    public function getMinute(): int
    {
        return $this->minute;
    }

    /**
     * @param int $minute
     */
    public function setMinute(int $minute)
    {
        $this->minute = $minute;
    }

    /**
     * @return int
     */
    public function getSecond(): int
    {
        return $this->second;
    }

    /**
     * @param int $second
     */
    public function setSecond(int $second)
    {
        $this->second = $second;
    }

    /**
     * @return int
     */
    public function getFraction(): int
    {
        return $this->fraction;
    }

    /**
     * Return fraction as decimal places
     * @return string
     */
    public function getFATFraction(): string
    {
        if (!$this->fraction || $this->fraction == 0) {
            return '00';
        }
        if ($this->fraction < 10) {
            return '0' . $this->fraction;
        }

        return $this->fraction;
    }

    /**
     * @param int $fraction
     */
    public function setFraction(int $fraction)
    {
        $this->fraction = $fraction;
    }

    public function __toString()
    {
        if ($this->getHour()) {
            return sprintf(
                '%s:%s:%s.%s',
                $this->getHour(),
                $this->getMinute() < 10 ? '0' . $this->getMinute() : $this->getMinute(),
                $this->getSecond() < 10 ? '0' . $this->getSecond() : $this->getSecond(),
                $this->getFATFraction()
            );
        } else if ($this->getMinute()) {
            return sprintf(
                '%s:%s.%s',
                $this->getMinute(),
                $this->getSecond() < 10 ? '0' . $this->getSecond() : $this->getSecond(),
                $this->getFATFraction()
            );
        } else if ($this->getSecond()) {
            return sprintf(
                '%s.%s',
                $this->getSecond(),
                $this->getFATFraction()
            );
        } else {
            return sprintf(
                '0.%s',
                $this->getFATFraction()
            );
        }
    }
}
