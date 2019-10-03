<?php
/**
 * @link    http://github.com/softbucket/enum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Softbucket\Enum;

/**
 * Helper class for Enum
 * 
 * @author Ed Mak <ed.mak.is@gmail.com>
 */
class EnumHelper extends Enum
{
    /**
     * The array elements will be of the type that is passed in. Keys will be the enum's name.
     * 
     * @param $className
     * @return Enum[]
     */
    public static function allEnums($className)
    {
        return Enum::getAllEnums($className);
    }

    /**
     * The return element will be either the passed in class type or null.
     * 
     * @param $className
     * @param $value
     * @return Enum
     */
    public static function findByValue($className, $value)
    {
        $allEnums = static::allEnums($className);
        
        /** @var Enum $enum */
        foreach ($allEnums as $enum) {
            if ($enum->value() === $value) {
                return $enum;
            }
        }
        return null;
    }

    /**
     * An alias of Enum::{$name}()
     *
     * @param $className
     * @param $name
     * @return Enum
     */
    public static function findByName($className, $name)
    {
        return $className::{$name}();
    }

    /**
     * Returns a key-value-pair that has the enum-names as keys and the enum-values as values. Returns null if class is not an enum.
     *
     * @param $className
     * @return array
     */
    public static function allEnumsAsKeyValuePair($className)
    {
        $allEnums = static::allEnums($className);
        $kvp = array();
        foreach ($allEnums as $enum) {
            $kvp[$enum->name()] = $enum->value();
        }
        return $kvp;
    }
}