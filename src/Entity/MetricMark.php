<?php

namespace Spikefalcon\TrackConverter\Entity;

class MetricMark
{
    /** @var int $meter */
    protected $meter;

    /** @var int $fraction */
    protected $fraction;

    /**
     * Time constructor.
     */
    public function __construct()
    {
        $this->meter = 0;
        $this->fraction = 0;
    }

    /**
     * @return int
     */
    public function getMeter(): int
    {
        return $this->meter;
    }

    /**
     * @param int $meter
     */
    public function setMeter(int $meter)
    {
        $this->meter = $meter;
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
        if ($this->getMeter()) {
            return sprintf(
                '%s.%sm',
                $this->getMeter(),
                $this->getFATFraction()
            );
        } else {
            return sprintf(
                '0.%sm',
                $this->getFATFraction()
            );
        }
    }
}
