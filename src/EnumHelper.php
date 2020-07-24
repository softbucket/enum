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
     * To mitigate performance issues of phpdoc reading, anything that validates the docblock is lazy-loaded
     * 
     * @param $className
     * @return Enum[]
     */
    public static function allEnums($className)
    {
        return Enum::getAllEnums($className);
    }
    /**
     * Validates the enum against the doc blocks.
     * To mitigate performance issues of phpdoc reading, anything that validates the docblock is lazy-loaded
     *
     * @param Enum $enum
     * @return boolean
     */
    public static function isDefined($enum)
    {
        $class = get_class($enum);
        Enum::initializeEnums($class);
        /** @var Enum $className */
        return isset(($enum::$enumsFromDocBlock)[$class][$enum->name()]);
    }

    /**
     * You will need these serialize/unserialize methods if you want to store and retrieve the enums for === to work properly
     * @param Enum $enum
     * @return string
     */
    public static function serialize($enum)
    {
        return \json_encode([
            'class' => get_class($enum),
            'value' => $enum->name()
        ], JSON_UNESCAPED_SLASHES);
    }

    /**
     * You will need these serialize/unserialize methods if you want to store and retrieve the enums for === to work properly
     *
     * @param string $enumString
     * @return mixed
     */
    public static function unserialize($enumString)
    {
        $json = json_decode($enumString, true);
        return $json['class']::{$json['value']}();
    }
}