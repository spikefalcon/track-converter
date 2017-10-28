<?php

namespace Spikefalcon\TrackConverter\Entity;

class EnglishMark
{
    /** @var int $foot */
    protected $foot;

    /** @var int $inch */
    protected $inch;

    /** @var int $fraction */
    protected $fraction;

    /**
     * Time constructor.
     */
    public function __construct()
    {
        $this->foot = 0;
        $this->inch = 0;
        $this->fraction = 0;
    }

    /**
     * @return int
     */
    public function getFoot(): int
    {
        return $this->foot;
    }

    /**
     * @param int $foot
     */
    public function setFoot(int $foot)
    {
        $this->foot = $foot;
    }

    /**
     * @return int
     */
    public function getInch(): int
    {
        return $this->inch;
    }

    /**
     * @param int $inch
     */
    public function setInch(int $inch)
    {
        $this->inch = $inch;
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
        if ($this->getFoot()) {
            return sprintf(
                '%s-%s.%s',
                $this->getFoot(),
                $this->getInch() < 10 ? '0' . $this->getInch() : $this->getInch(),
                $this->getFATFraction()
            );
        } else if ($this->getInch()) {
            return sprintf(
                '%s.%s',
                $this->getInch() < 10 ? '0' . $this->getInch() : $this->getInch(),
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
