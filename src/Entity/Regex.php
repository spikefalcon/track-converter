<?php

namespace Spikefalcon\TrackConverter\Entity;

/**
 * Class Regex
 *
 * Represents a single regular expression
 *
 * @package Spikefalcon\TrackConverter\Entity
 */
class Regex
{
    /** @var string $regex */
    protected $regex;

    /** @var string $modifiers */
    protected $modifiers;

    /**
     * @param string|null $regex
     * @param string|null $modifiers
     */
    public function __construct($regex = null, $modifiers = null)
    {
        $this->setRegex($regex);
        $this->setModifiers($modifiers);
    }

    /**
     * @return string
     */
    public function getFormattedRegex()
    {
        return '/'.$this->regex.'/'.$this->modifiers;
    }

    /**
     * @return string
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * @param string $regex
     *
     * @return Regex
     */
    public function setRegex($regex)
    {
        $this->regex = $regex;

        return $this;
    }

    /**
     * @param string|Regex $regex
     *
     * @return Regex
     */
    public function addToRegex($regex)
    {
        if ($regex instanceof Regex) {
            $this->regex .= $regex->getRegex();
        } else {
            $this->regex .= $regex;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    /**
     * @param string $modifiers
     *
     * @return Regex
     */
    public function setModifiers($modifiers)
    {
        $this->modifiers = $modifiers;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->regex;
    }
}
