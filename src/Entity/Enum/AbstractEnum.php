<?php

namespace Spikefalcon\TrackConverter\Entity\Enum;

/**
 * Class AbstractEnum
 *
 * http://stackoverflow.com/questions/254514/php-and-enumeration
 *
 * @package Spikefalcon\TrackConverter\Entity\Enum
 */
abstract class AbstractEnum
{
    /**
     * @var null
     */
    private static $constCacheArray = null;

    /**
     * @return mixed
     */
    private static function getConstants()
    {
        if (self::$constCacheArray == null) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    /**
     * Get all values of a given enum class
     *
     * @return array
     */
    public static function getValues()
    {
        return array_values(self::getConstants());
    }

    /**
     * Determine if $name is a valid enum  name
     *
     * param string $name
     * @param bool $strict

     * @return bool
     */
    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    /**
     * Determine if $value is a valid enum value
     *
     * @param string $value
     *
     * @return bool
     */
    public static function isValidValue($value)
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict = true);
    }

    /**
     * @param $value
     *
     * Get the name of a constant by passing in its value
     *
     * @return mixed
     */
    public static function getName($value)
    {
        $names = array_flip(self::getConstants());

        return $names[$value];
    }
}
