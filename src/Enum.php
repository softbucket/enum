<?php
/**
 * @link    http://github.com/softbucket/enum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Softbucket\Enum;

/**
 * Base Enum class
 *
 * Implement by providing the methods in the class docblock
 *
 * @author Ed Mak <ed.mak.is@gmail.com>
 */
abstract class Enum
{
    /** @var Enum[][] */
    protected static $enumCacheFromName = array();

    /** @var string  */
    protected $enumName;

    protected function __construct($enumName)
    {
        $this->enumName = $enumName;
    }

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
        $enum = isset(static::$enumCacheFromName[$className][$enumName]) ? static::$enumCacheFromName[$className][$enumName] : null;
        if ($enum !== null) {
            return $enum;
        }

        if (static::enforceDocBlock() === false) { //ie we can always use $enumName
            static::$enumCacheFromName[$className][$enumName] = new static($enumName);
        } else if (!isset(self::$enumCacheFromName[$className])) { //ie the cache has nothing and we have to build it from the docblocks
            static::$enumCacheFromName[$className] = static::buildNewEnumsFromDocblocks($className);
        }

        $enum = isset(static::$enumCacheFromName[$className][$enumName]) ? static::$enumCacheFromName[$className][$enumName] : null;
        return $enum;
    }

    /**
     * You can override this method to return false if you want to avoid docblock parsing (which is a theoretical speed up)
     * @return bool
     */
    protected static function enforceDocBlock()
    {
        return true;
    }

    protected static function buildNewEnumsFromDocBlocks($className)
    {
        $enums = array();
        try {
            $reflection = new \ReflectionClass($className);
        } catch (\Exception  $e) {
            return $enums;
        }

        $docBlock = $reflection->getDocComment();
        $splitDocBlocks = explode("\n", $docBlock);
        foreach ($splitDocBlocks as $docBlockChunk) {
            $spaceDelimitedTokens = explode(' ', $docBlockChunk);
            $methodName = null;
            foreach ($spaceDelimitedTokens as $token) {
                $tokenLength = strlen($token);
                $brackets = substr($token, $tokenLength - 2);
                if ($brackets === '()') {
                    $methodName = substr($token, 0, $tokenLength - 2);
                    break;
                }
            }
            if ($methodName !== null) {
                $enums[$methodName] = new static($methodName);
            }
        }
        return $enums;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->enumName;
    }
}
