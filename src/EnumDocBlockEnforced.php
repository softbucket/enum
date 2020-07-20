<?php
/**
 * @link    http://github.com/softbucket/enum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

/** @noinspection PhpFullyQualifiedNameUsageInspection */
namespace Softbucket\Enum;

/**
 * Base Enum class
 *
 * Same as Enum, except it enforces the doc block (ie misses will return null)
 *
 * @author Ed Mak <ed.mak.is@gmail.com>
 */
abstract class EnumDocBlockEnforced extends Enum
{
    /**
     * @param string $methodName
     * @param array $arguments
     *
     * @return static|null
     */
    public static function __callStatic($methodName, $arguments)
    {
        $className = static::class;
        return static::getEnumFromName($className, $methodName);
    }

    /**
     * @param string $className
     * @param string $enumName
     *
     * @return static
     */
    protected static function getEnumFromName($className, $enumName)
    {
        $enum = isset(self::$enumCacheFromName[$className][$enumName]) ? static::$enumCacheFromName[$className][$enumName] : null;
        if ($enum !== null) {
            return $enum;
        }

        static::initializeEnums($className);

        $enum = isset(self::$enumCacheFromName[$className][$enumName]) ? static::$enumCacheFromName[$className][$enumName] : null;
        return $enum;
    }
}
